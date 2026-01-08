@extends('user.layout')

@section('title', 'My Wishlist')

@section('user-content')
@if($wishlist->isEmpty())
    <p class="text-gray-500">Your wishlist is empty.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($wishlist as $item)
            <div class="border rounded-lg p-4">
                <img src="{{ $item->product->image }}" class="h-40 w-full object-cover rounded">
                <h3 class="mt-2 font-semibold">{{ $item->product->name }}</h3>
                <p class="text-indigo-600 font-bold">${{ $item->product->price }}</p>
                <a href="{{ route('shop.show', $item->product->slug) }}"
                   class="mt-2 inline-block text-sm text-indigo-600 hover:underline">
                    View Product →
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection
