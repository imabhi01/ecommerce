<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $wishlistItems = Wishlist::with('product.primaryImage', 'product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ], 400);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlist_count' => Auth::user()->wishlist()->count()
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlist_count' => Auth::user()->wishlist()->count()
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $inWishlist = false;
            $message = 'Removed from wishlist';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            $inWishlist = true;
            $message = 'Added to wishlist';
        }

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'message' => $message,
            'wishlist_count' => Auth::user()->wishlist()->count()
        ]);
    }

    public function moveToCart($id)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Add to cart
        $cartItem = \App\Models\Cart::where('user_id', Auth::id())
            ->where('product_id', $wishlistItem->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            \App\Models\Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $wishlistItem->product_id,
                'quantity' => 1
            ]);
        }

        // Remove from wishlist
        $wishlistItem->delete();

        return back()->with('success', 'Product moved to cart');
    }

    public function clear()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Wishlist cleared');
    }
}
