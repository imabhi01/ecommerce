@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('orders.index') }}" 
           class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Order Details</h1>
                <p class="text-gray-600">Order #{{ $order->order_number }}</p>
            </div>
            
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button onclick="window.print()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </button>
                
                @if(in_array($order->status, ['pending', 'processing']))
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                    Cancel Order
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Status Timeline -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Order Status</h2>
                
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    
                    <div class="space-y-6">
                        <!-- Order Placed -->
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-600 text-white font-bold z-10">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold">Order Placed</h3>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Processing -->
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full z-10
                                @if(in_array($order->status, ['processing', 'shipped', 'delivered'])) bg-green-600 text-white @else bg-gray-300 text-gray-600 @endif">
                                @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <span>2</span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold">Processing</h3>
                                <p class="text-sm text-gray-600">
                                    @if($order->status === 'processing') In progress
                                    @elseif(in_array($order->status, ['shipped', 'delivered'])) Completed
                                    @else Pending
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Shipped -->
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full z-10
                                @if(in_array($order->status, ['shipped', 'delivered'])) bg-green-600 text-white @else bg-gray-300 text-gray-600 @endif">
                                @if(in_array($order->status, ['shipped', 'delivered']))
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <span>3</span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold">Shipped</h3>
                                <p class="text-sm text-gray-600">
                                    @if($order->status === 'shipped') In transit
                                    @elseif($order->status === 'delivered') Delivered
                                    @else Not yet shipped
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Delivered -->
                        <div class="relative flex items-start">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full z-10
                                @if($order->status === 'delivered') bg-green-600 text-white @else bg-gray-300 text-gray-600 @endif">
                                @if($order->status === 'delivered')
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <span>4</span>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold">Delivered</h3>
                                <p class="text-sm text-gray-600">
                                    @if($order->status === 'delivered') Package received
                                    @else Awaiting delivery
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6">Order Items</h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 pb-4 border-b last:border-b-0">
                        @if($item->product && $item->product->primaryImage)
                            <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" 
                                 alt="{{ $item->product_name }}" 
                                 class="w-24 h-24object-cover rounded-lg">
@else
<div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
<span class="text-gray-400 text-3xl">📦</span>
</div>
@endif
<div class="flex-1">
                        <h4 class="font-semibold text-lg">{{ $item->product_name }}</h4>
                        <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                        <p class="text-sm text-gray-500">Price: ${{ number_format($item->price, 2) }} each</p>
                        
                        @if($item->product)
                        <a href="{{ route('shop.show', $item->product->slug) }}" 
                           class="text-indigo-600 hover:underline text-sm mt-2 inline-block">
                            View Product
                        </a>
                        @endif
                    </div>
                    
                    <div class="text-right">
                        <p class="font-bold text-lg">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        
                        @if($order->status === 'delivered')
                        <button class="text-sm text-indigo-600 hover:underline mt-2">
                            Write a Review
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
            
            <div class="space-y-3 mb-4">
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
                <div class="border-t pt-3 flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span class="text-indigo-600">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            @if($order->payment)
            <div class="border-t pt-4">
                <h3 class="font-semibold mb-2">Payment Information</h3>
                <div class="text-sm space-y-1 text-gray-600">
                    <p>Method: <span class="font-medium text-gray-900">{{ ucfirst($order->payment->payment_method) }}</span></p>
                    <p>Transaction: <span class="font-medium text-gray-900">{{ $order->payment->transaction_id }}</span></p>
                    <p>Status: 
                        <span class="font-medium
                            @if($order->payment->status === 'completed') text-green-600
                            @elseif($order->payment->status === 'pending') text-yellow-600
                            @else text-red-600
                            @endif">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </p>
                </div>
            </div>
            @endif
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
            <div class="text-gray-700 space-y-1">
                <p class="font-semibold">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                <p>{{ $order->shipping_country }}</p>
                <p class="text-gray-600 mt-3">{{ $order->shipping_email }}</p>
            </div>
        </div>

        <!-- Customer Support -->
        <div class="bg-indigo-50 rounded-lg p-6">
            <h3 class="font-bold mb-2">Need Help?</h3>
            <p class="text-sm text-gray-700 mb-4">Contact our customer support team for any questions about your order.</p>
            <a href="#" class="text-indigo-600 hover:underline font-medium text-sm">
                Contact Support →
            </a>
        </div>
    </div>
</div>
</div>
<!-- Print Styles -->
<style>
    @media print {
        nav, footer, button, .no-print {
            display: none !important;
        }
    }
</style>
@endsection