<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'session_id' => session()->getId(),
                'product_id' => $request->product_id
            ],
            ['quantity' => \DB::raw('quantity + ' . $request->quantity)]
        );

        return back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cartItem = Cart::findOrFail($id);
        
        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock available');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated');
    }

    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return back()->with('success', 'Item removed from cart');
    }

    private function getCartItems()
    {
        return Cart::with('product.primaryImage')
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('session_id', session()->getId());
            })
            ->get();
    }
}
