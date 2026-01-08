@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">My Orders</h1>
        <a href="{{ route('shop.index') }}" 
           class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Continue Shopping
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h2 class="text-2xl font-semibold mb-4">No orders yet</h2>
            <p class="text-gray-600 mb-8">You haven't placed any orders yet. Start shopping to see your orders here!</p>
            <a href="{{ route('shop.index') }}" 
               class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-block font-semibold">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Order Header -->
                <div class="bg-gray-50 px-6 py-4 border-b flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1 mb-4 md:mb-0">
                        <p class="text-sm text-gray-600">Order Number</p>
                        <p class="font-bold text-lg">{{ $order->order_number }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-600">Date</p>
                            <p class="font-semibold text-sm">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Total</p>
                            <p class="font-semibold text-sm">${{ number_format($order->total, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Status</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex items-end justify-end md:justify-start">
                            <a href="{{ route('orders.show', $order) }}" 
                               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($order->items->take(3) as $item)
                        <div class="flex items-center space-x-4">
                            @if($item->product && $item->product->primaryImage)
                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-xl">📦</span>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h4 class="font-semibold">{{ $item->product_name }}</h4>
                                <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="font-semibold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                        @endforeach

                        @if($order->items->count() > 3)
                        <p class="text-sm text-gray-600 text-center pt-2">
                            + {{ $order->items->count() - 3 }} more item(s)
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t flex flex-wrap gap-3">
                    <a href="{{ route('orders.show', $order) }}" 
                       class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium text-sm">
                        View Order
                    </a>
                    
                    @if($order->status === 'delivered')
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 font-medium text-sm">
                        Buy Again
                    </button>
                    @endif
                    
                    @if(in_array($order->status, ['pending', 'processing']))
                    <button class="px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 font-medium text-sm">
                        Cancel Order
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection