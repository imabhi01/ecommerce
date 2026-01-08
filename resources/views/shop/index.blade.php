@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-12 mb-12 text-white">
        <h1 class="text-5xl font-bold mb-4">Welcome to ModernShop</h1>
        <p class="text-xl mb-8">Discover amazing products at unbeatable prices</p>
        <a href="#products" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 inline-block">
            Shop Now
        </a>
    </div>

    <!-- Categories -->
    @if($categories->isNotEmpty())
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('shop.category', $category->slug) }}" 
               class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="w-16 h-16 mx-auto mb-3 object-cover rounded-full">
                @else
                    <div class="w-16 h-16 mx-auto mb-3 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                @endif
                <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Products Grid -->
    <div id="products">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">All Products</h2>
            <div class="flex items-center space-x-4">
                <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option>Sort by: Featured</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow relative">
                <!-- Wishlist Button -->
                <x-wishlist-button :product="$product" classes="absolute top-2 right-2 bg-white rounded-full p-2 shadow-md hover:bg-gray-50 z-10" />
                
                <!-- Product Image -->
                <a href="{{ route('shop.show', $product->slug) }}">

                    <!-- Lazy Loading Implementation -->
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/' . str_replace('.', '_thumb.', $product->primaryImage->image_path)) }}" 
                            data-src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                            alt="{{ $product->name }}" 
                            class="w-full h-64 object-cover lazy-load"
                            loading="lazy">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-4xl">📷</span>
                        </div>
                    @endif

                    <!-- Without Lazy Loading Implementation -->

                    <!-- @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-4xl">📷</span>
                        </div>
                    @endif -->
                </a>
                
                <div class="p-4">
                    <a href="{{ route('shop.show', $product->slug) }}" class="text-sm text-indigo-600 hover:underline">
                        {{ $product->category->name }}
                    </a>
                    <h3 class="font-semibold text-lg mb-2 truncate">
                        <a href="{{ route('shop.show', $product->slug) }}" class="hover:text-indigo-600">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            @if($product->compare_price)
                                <span class="text-sm text-gray-500 line-through ml-2">
                                    ${{ number_format($product->compare_price, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" 
                                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-xl">No products found.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection