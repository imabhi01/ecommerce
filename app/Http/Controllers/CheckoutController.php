<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends Controller
{
     public function index()
    {
        $cartItems = Cart::with('product')
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('session_id', session()->getId());
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = 10.00;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total'));
    }

    public function processStripe(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zip' => 'required|string',
            'shipping_country' => 'required|string',
            'stripeToken' => 'required' // this is PaymentMethod ID
        ]);

        try {
            DB::beginTransaction();

            $cartItems = $this->getCartItems();
            $orderData = $this->calculateOrderTotals($cartItems);

            Stripe::setApiKey(config('services.stripe.secret'));

            // ✅ Create PaymentIntent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => (int) round($orderData['total'] * 100),
                'currency' => 'usd',
                'payment_method' => $request->stripeToken,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            if ($paymentIntent->status !== 'succeeded') {
                throw new \Exception('Payment not completed');
            }

            $order = $this->createOrder($validated, $orderData);
            $this->createOrderItems($order, $cartItems);

            $this->createPayment(
                $order,
                'stripe',
                $paymentIntent->id,
                $orderData['total'],
                'completed'
            );

            $this->updateStock($cartItems);
            $this->clearCart();

            DB::commit();

            return redirect()->route('order.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function processPayPal(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zip' => 'required|string',
            'shipping_country' => 'required|string'
        ]);

        try {
            $cartItems = $this->getCartItems();
            $orderData = $this->calculateOrderTotals($cartItems);

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($orderData['total'], 2, '.', '')
                    ]
                ]],
                "application_context" => [
                    "return_url" => route('checkout.paypal.success'),
                    "cancel_url" => route('checkout.paypal.cancel')
                ]
            ]);

            session()->put('paypal_order_data', array_merge($validated, $orderData));

            return redirect($order['links'][1]['href']);

        } catch (\Exception $e) {
            return back()->with('error', 'PayPal payment failed: ' . $e->getMessage());
        }
    }

    public function paypalSuccess(Request $request)
    {
        try {
            DB::beginTransaction();

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->token);

            if ($response['status'] === 'COMPLETED') {
                $orderData = session()->get('paypal_order_data');
                $cartItems = $this->getCartItems();

                $order = $this->createOrder($orderData, $orderData);
                $this->createOrderItems($order, $cartItems);
                $this->createPayment($order, 'paypal', $response['id'], $orderData['total'], 'completed');

                $this->updateStock($cartItems);
                $this->clearCart();
                session()->forget('paypal_order_data');

                DB::commit();

                return redirect()->route('order.success', $order->id);
            }

            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Payment verification failed');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Payment processing failed');
        }
    }

    private function getCartItems()
    {
        return Cart::with('product')
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('session_id', session()->getId());
            })
            ->get();
    }

    private function calculateOrderTotals($cartItems)
    {
        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $shipping = 10.00;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return compact('subtotal', 'shipping', 'tax', 'total');
    }

    private function createOrder($validated, $orderData)
    {
        return Order::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'subtotal' => $orderData['subtotal'],
            'tax' => $orderData['tax'],
            'shipping' => $orderData['shipping'],
            'total' => $orderData['total'],
            'status' => 'processing'
        ]));
    }

    private function createOrderItems($order, $cartItems)
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity
            ]);
        }
    }

    private function createPayment($order, $method, $transactionId, $amount, $status)
    {
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $method,
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'status' => $status
        ]);
    }

    private function updateStock($cartItems)
    {
        foreach ($cartItems as $item) {
            $item->product->decrement('stock', $item->quantity);
        }
    }

    private function clearCart()
    {
        Cart::where(function($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('session_id', session()->getId());
        })->delete();
    }
}
