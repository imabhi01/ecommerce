@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-green-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Products</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalProducts }}</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Customers</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalCustomers }}</p>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Recent Orders -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Orders -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:underline text-sm">
                View All
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Order #</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Customer</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Total</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline font-medium">
                                {{ $order->order_number }}
                            </a>
                        </td>
                        <td class="py-3 px-4">{{ $order->user->name }}</td>
                        <td class="py-3 px-4 font-semibold">{{ number_format($order->total, 2) }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">No orders yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                    </table>
                    </div>
                </div>

<!-- Order Status Distribution -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-bold mb-6">Order Status</h3>
    <div class="space-y-4">
        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
        <div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">{{ ucfirst($status) }}</span>
                <span class="text-sm font-bold text-gray-900">{{ $ordersByStatus->get($status, 0) }}</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                @php
                    $percentage = $totalOrders > 0 ? ($ordersByStatus->get($status, 0) / $totalOrders * 100) : 0;
                @endphp
                <div class="h-2 rounded-full
                    @if($status === 'pending') bg-yellow-500
                    @elseif($status === 'processing') bg-blue-500
                    @elseif($status === 'shipped') bg-purple-500
                    @elseif($status === 'delivered') bg-green-500
                    @else bg-red-500
                    @endif"
                    style="width: {{ $percentage }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>
<!-- Top Products -->
<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h3 class="text-xl font-bold mb-6">Top Selling Products</h3>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        @foreach($topProducts as $product)
        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
            @if($product->primaryImage)
                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-32 object-cover rounded-lg mb-3">
            @else
                <div class="w-full h-32 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                    <span class="text-gray-400 text-3xl">📦</span>
                </div>
            @endif
            <h4 class="font-semibold text-sm truncate">{{ $product->name }}</h4>
            <p class="text-gray-600 text-xs">{{ $product->order_items_count }} sold</p>
        </div>
        @endforeach
    </div>
</div>
@endsection