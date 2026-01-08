@extends('layouts.admin')

@section('page-title', 'Orders')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Order Management</h2>
    <p class="text-gray-600">View and manage customer orders</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" 
                   name="search" 
                   placeholder="Search by order #, name, email..." 
                   value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <select name="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-semibold">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Order #</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Customer</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Items</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Total</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="py-4 px-6">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="text-indigo-600 hover:underline font-semibold">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td class="py-4 px-6">
                        <p class="font-medium text-gray-900">{{ $order->shipping_name }}</p>
                        <p class="text-sm text-gray-600">{{ $order->shipping_email }}</p>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600">
                        {{ $order->created_at->format('M d, Y') }}
                        <br>
                        <span class="text-xs">{{ $order->created_at->format('h:i A') }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="text-gray-600">{{ $order->items->count() }} items</span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status === 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                           class="text-indigo-600 hover:text-indigo-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12">
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-xl font-semibold">No orders found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="px-6 py-4 border-t">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection