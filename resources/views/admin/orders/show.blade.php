@extends('layouts.admin')

@section('page-title', 'Order Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" 
       class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Orders
    </a>
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h2>
            <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
        </div>
        <button onclick="window.print()" 
                class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-semibold flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Update Order Status</h3>
            
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-end space-x-4">
                @csrf
                @method('PATCH')
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <button type="submit" 
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Order Items</h3>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center space-x-4 pb-4 border-b last:border-b-0">
                    @if($item->product && $item->product->primaryImage)
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
                        <p class="text-sm text-gray-600">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="font-bold">${{ number_format($item->price * $item->quantity, 2) }}</p>
                        <p class="text-sm text-gray-600">${{ number_format($item->price, 2) }} each</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Total -->
            <div class="border-t pt-4 mt-4 space-y-2">
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
                <div class="border-t pt-2 flex justify-between text-xl font-bold">
                    <span>Total</span>
                    <span class="text-indigo-600">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Customer Information</h3>
            
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600 mb-1">Name</p>
                    <p class="font-semibold">{{ $order->user->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Email</p>
                    <p class="font-semibold">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Customer Since</p>
                    <p class="font-semibold">{{ $order->user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Shipping Address</h3>
            
            <div class="text-sm text-gray-700 space-y-1">
                <p class="font-semibold">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                <p>{{ $order->shipping_country }}</p>
                <p class="mt-3 text-gray-600">{{ $order->shipping_email }}</p>
            </div>
        </div>

        <!-- Payment Information -->
        @if($order->payment)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Payment Information</h3>
            
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600 mb-1">Payment Method</p>
                    <p class="font-semibold capitalize">{{ $order->payment->payment_method }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Transaction ID</p>
                    <p class="font-mono text-xs bg-gray-100 p-2 rounded break-all">{{ $order->payment->transaction_id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Payment Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        @if($order->payment->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->payment->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Amount Paid</p>
                    <p class="font-semibold">${{ number_format($order->payment->amount, 2) }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Notes -->
        @if($order->notes)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Order Notes</h3>
            <p class="text-sm text-gray-700">{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Activity Log -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold mb-4">Order Timeline</h3>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="text-sm font-semibold">Order Placed</p>
                        <p class="text-xs text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                
                @if($order->payment)
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="text-sm font-semibold">Payment Received</p>
                        <p class="text-xs text-gray-600">{{ $order->payment->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
                
                @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="text-sm font-semibold">Processing</p>
                        <p class="text-xs text-gray-600">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
                
                @if(in_array($order->status, ['shipped', 'delivered']))
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-purple-600 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="text-sm font-semibold">Shipped</p>
                        <p class="text-xs text-gray-600">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
                
                @if($order->status === 'delivered')
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="text-sm font-semibold">Delivered</p>
                        <p class="text-xs text-gray-600">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
                
                @if($order->status === 'cancelled')
                <div class="flex items-start">
                    <div class="w-2 h-2 bg-red-600 rounded-full mt-2 mr-3"></div>
                    <div>
                        <p class="text-sm font-semibold">Cancelled</p>
                        <p class="text-xs text-gray-600">{{ $order->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        nav, button, .no-print {
            display: none !important;
        }
    }
</style>
@endsection