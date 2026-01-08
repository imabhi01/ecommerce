@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex gap-8">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white rounded-lg shadow-md p-6 h-fit">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('user.dashboard') }}"
                   class="block px-4 py-2 rounded bg-indigo-600 text-white">
                    Dashboard
                </a>

                <a href="{{ route('user.orders') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    My Orders
                </a>

                <a href="{{ route('user.wishlist') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Wishlist
                </a>

                <a href="#"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Profile Settings
                </a>

                <a href="{{ route('cart.index') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100">
                    Cart
                </a>
            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 space-y-10">

            <!-- WELCOME -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold mb-2">
                    Welcome, {{ auth()->user()->name }} 👋
                </h1>
                <p class="text-gray-600">
                    Manage your orders, wishlist and account settings here.
                </p>
            </div>

            <!-- ORDERS -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">My Orders</h2>
                    <a href="{{ route('user.orders') }}" class="text-indigo-600 text-sm hover:underline">
                        View All
                    </a>
                </div>

                @if($orders->isEmpty())
                    <p class="text-gray-500">You have not placed any orders yet.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">Order #</th>
                                    <th class="p-3 text-left">Total</th>
                                    <th class="p-3 text-left">Status</th>
                                    <th class="p-3 text-left">Date</th>
                                    <th class="p-3 text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="border-t">
                                        <td class="p-3 font-medium">#{{ $order->id }}</td>
                                        <td class="p-3">${{ number_format($order->total, 2) }}</td>
                                        <td class="p-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $order->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="p-3">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                               class="text-indigo-600 hover:underline text-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- WISHLIST -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Wishlist</h2>
                    <a href="{{ route('wishlist.index') }}" class="text-indigo-600 text-sm hover:underline">
                        View All
                    </a>
                </div>

                @if($wishlist->isEmpty())
                    <p class="text-gray-500">Your wishlist is empty.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($wishlist as $item)
                            <div class="border rounded-lg p-4">
                                <img src="{{ $item->product->image ?? 'https://via.placeholder.com/300' }}"
                                     class="h-40 w-full object-cover rounded">
                                <h3 class="mt-2 font-semibold">
                                    {{ $item->product->name }}
                                </h3>
                                <p class="text-indigo-600 font-bold">
                                    ${{ number_format($item->product->price, 2) }}
                                </p>

                                <div class="flex justify-between items-center mt-3">
                                    <a href="{{ route('shop.show', $item->product->slug) }}"
                                       class="text-sm text-indigo-600 hover:underline">
                                        View
                                    </a>

                                    <form method="POST" action="{{ route('wishlist.remove', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600 hover:underline">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
