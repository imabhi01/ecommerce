@extends('user.layout')

@section('title', 'My Orders')

@section('user-content')
@if($orders->isEmpty())
    <p class="text-gray-500">You have not placed any orders yet.</p>
@else
    <table class="w-full text-left border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Order #</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr class="border-t">
                    <td class="p-3">{{ $order->id }}</td>
                    <td class="p-3">${{ number_format($order->total, 2) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $order->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
