<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
   public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $wishlist = Auth::user()->wishlist;

        return view('user.dashboard', compact('orders', 'wishlist'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        return view('user.order-show', compact('order'));
    }

    public function cancel(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Order cancelled successfully.');
    }

    public function requestReturn(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if ($order->status !== 'paid') {
            return back()->with('error', 'Return not allowed.');
        }

        $order->update(['status' => 'return_requested']);
        return back()->with('success', 'Return request submitted.');
    }
}
