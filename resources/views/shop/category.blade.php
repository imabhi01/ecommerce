@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Category Header -->
    <div class="mb-8">
        @if($category->image)
        <div class="relative h-64 rounded-lg overflow-hidden mb-6">
            <img src="{{ asset('storage/' . $category->image) }}" 
                 alt="{{ $category->name }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end">
                <div class="p-8">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $category->name }}</h1>
                    @if($category->description)
                        <p class="text-white/90">{{ $category->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        @else
        <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-gray-600">{{ $category->description }}</p>
        @endif
        @endif

        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Shop</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">{{ $category->name }}</span>
        </nav>
    </div>

    <!-- Products Count and Sorting -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <p class="text-gray-600 mb-4 md:mb-0">
                {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }} found
            </p>
            
            <form action="{{ route('shop.category', $category->slug) }}" method="GET" class="flex items-center">
                <label class="mr-2 text-gray-600">Sort by:</label>
                <select name="sort" 
                        onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>Name: A-Z</option>
                    <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>Name: Z-A</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <h2 class="text-2xl font-semibold mb-4">No Products Found</h2>
            <p class="text-gray-600 mb-8">There are no products in this category yet.</p>
            <a href="{{ route('shop.index') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                Browse All Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow relative">
                <!-- Wishlist Button -->
                @auth
                <x-wishlist-button :product="$product" classes="absolute top-2 right-2 bg-white rounded-full p-2 shadow-md hover:bg-gray-50 z-10" />
                @endauth

                <!-- Product Image -->
                <a href="{{ route('shop.show', $product->slug) }}">
                    @if($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-4xl">📷</span>
                        </div>
                    @endif
                </a>
                
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2 truncate">
                        <a href="{{ route('shop.show', $product->slug) }}" class="hover:text-indigo-600">
                            {{ $product->name }}
                        </a>
                    </h3>
                    
                    <!-- Reviews -->
                    @if($product->totalReviews() > 0)
                    <div class="flex items-center mb-2">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($product->averageRating()))
                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-1 text-sm text-gray-600">({{ $product->totalReviews() }})</span>
                    </div>
                    @endif

                    <!-- Price -->
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

                    <!-- Stock Status -->
                    @if($product->stock > 0)
                        @if($product->stock <= 5)
                            <p class="text-sm text-orange-600 mb-4">Only {{ $product->stock }} left in stock!</p>
                        @endif
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
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection