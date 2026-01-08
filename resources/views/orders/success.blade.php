@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Success Message -->
    <div class="text-center py-12">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Order Successful!</h1>
        <p class="text-xl text-gray-600 mb-2">Thank you for your purchase</p>
        <p class="text-lg text-gray-500 mb-8">
            Order #{{ $order->order_number }}
        </p>

        <div class="flex justify-center space-x-4">
            <a href="{{ route('orders.show', $order) }}" 
               class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                View Order Details
            </a>
            <a href="{{ route('shop.index') }}" 
               class="bg-white text-indigo-600 border-2 border-indigo-600 px-8 py-3 rounded-lg hover:bg-indigo-50 font-semibold">
                Continue Shopping
            </a>
        </div>
    </div>

    <!-- Order Summary Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Order Summary</h2>
        </div>

        <div class="p-6">
            <!-- Order Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Date</p>
                    <p class="font-semibold">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                    <p class="font-semibold">{{ ucfirst($order->payment->payment_method ?? 'N/A') }}</p>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="border-t pt-6 mb-6">
                <h3 class="font-bold text-lg mb-3">Shipping Address</h3>
                <div class="text-gray-700">
                    <p class="font-semibold">{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                    <p>{{ $order->shipping_country }}</p>
                    <p class="mt-2 text-gray-600">{{ $order->shipping_email }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t pt-6">
                <h3 class="font-bold text-lg mb-4">Order Items</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 pb-4 border-b last:border-b-0">
                        @if($item->product->primaryImage)
                            <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" 
                                 alt="{{ $item->product_name }}" 
                                 class="w-20 h-20 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-400 text-2xl">📦</span>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h4 class="font-semibold">{{ $item->product_name }}</h4>
                            <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                        
                        <div class="text-right">
                            <p class="font-semibold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                            <p class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Total -->
            <div class="border-t pt-6 mt-6">
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-2xl font-bold pt-2 border-t">
                        <span>Total</span>
                        <span class="text-indigo-600">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- What's Next -->
    <div class="bg-blue-50 rounded-lg p-6 mb-8">
        <h3 class="font-bold text-lg mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            What's Next?
        </h3>
        <ul class="space-y-2 text-gray-700">
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>You'll receive an order confirmation email at <strong>{{ $order->shipping_email }}</strong></span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>We'll send you shipping notifications as your order is processed</span>
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 mr-2 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Track your order status in your <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:underline">order history</a></span>
            </li>
        </ul>
    </div>

    <!-- Help Section -->
    <div class="text-center text-gray-600 mb-8">
        <p class="mb-2">Need help with your order?</p>
        <a href="#" class="text-indigo-600 hover:underline font-medium">Contact Customer Support</a>
    </div>
</div>
@endsection