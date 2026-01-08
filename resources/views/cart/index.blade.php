@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-8">Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2 class="text-2xl font-semibold mb-4">Your cart is empty</h2>
            <p class="text-gray-600 mb-8">Add some products to get started!</p>
            <a href="{{ route('shop.index') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                    <img src="{{ $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : 'https://via.placeholder.com/150' }}" 
                         alt="{{ $item->product->name }}" 
                         class="w-24 h-24 object-cover rounded-lg">
                    
                    <div class="ml-6 flex-1">
                        <h3 class="font-semibold text-lg">
                            <a href="{{ route('shop.show', $item->product->slug) }}" class="hover:text-indigo-600">
                                {{ $item->product->name }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm">{{ $item->product->category->name }}</p>
                        <p class="text-xl font-bold mt-2">${{ number_format($item->product->price, 2) }}</p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PATCH')
                            <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit();" 
                                    class="px-3 py-1 bg-gray-200 rounded-l-lg hover:bg-gray-300">-</button>
                            <input type="number" 
                                   name="quantity" 
                                   value="{{ $item->quantity }}" 
                                   min="1" 
                                   max="{{ $item->product->stock }}"
                                   class="w-16 text-center border-t border-b border-gray-200 py-1"
                                   onchange="this.form.submit()">
                            <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit();" 
                                    class="px-3 py-1 bg-gray-200 rounded-r-lg hover:bg-gray-300">+</button>
                        </form>

                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-2xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="font-semibold">$10.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (10%)</span>
                            <span class="font-semibold">${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <div class="border-t pt-4 flex justify-between text-xl">
                            <span class="font-bold">Total</span>
                            <span class="font-bold text-indigo-600">
                                ${{ number_format($total + 10 + ($total * 0.1), 2) }}
                            </span>
                        </div>
                    </div>
                    @auth
                    <a href="{{ route('checkout.index') }}" 
                       class="block w-full bg-indigo-600 text-white text-center px-6 py-4 rounded-lg hover:bg-indigo-700 font-semibold text-lg mb-4">
                        Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="block w-full bg-indigo-600 text-white text-center px-6 py-4 rounded-lg hover:bg-indigo-700 font-semibold text-lg mb-4">
                        Login to Checkout
                    </a>
                @endauth

                <a href="{{ route('shop.index') }}" 
                   class="block w-full text-center text-indigo-600 hover:text-indigo-800 font-medium">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
@endif
</div>
@endsection
