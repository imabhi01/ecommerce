@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2">
            @if(request('q'))
                Search Results for "{{ request('q') }}"
            @else
                All Products
            @endif
        </h1>
        <p class="text-gray-600">{{ $products->total() }} products found</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-4">Filters</h2>
                
                <form action="{{ route('search') }}" method="GET" id="filterForm">
                    <!-- Keep search query -->
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3">Category</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="category" 
                                       value="" 
                                       {{ !request('category') ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="mr-2">
                                <span>All Categories</span>
                            </label>
                            @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="radio" 
                                       name="category" 
                                       value="{{ $category->id }}" 
                                       {{ request('category') == $category->id ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="mr-2">
                                <span>{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3">Price Range</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Min Price</label>
                                <input type="number" 
                                       name="min_price" 
                                       value="{{ request('min_price') }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="${{ number_format($priceRange->min_price ?? 0, 2) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Max Price</label>
                                <input type="number" 
                                       name="max_price" 
                                       value="{{ request('max_price') }}"
                                       step="0.01"
                                       min="0"
                                       placeholder="${{ number_format($priceRange->max_price ?? 0, 2) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Availability -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3">Availability</h3>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="in_stock" 
                                   value="1"
                                   {{ request('in_stock') ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="mr-2">
                            <span>In Stock Only</span>
                        </label>
                    </div>

                    <!-- Featured Products -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="featured" 
                                   value="1"
                                   {{ request('featured') ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="mr-2">
                            <span>Featured Products</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-semibold mb-2">
                        Apply Filters
                    </button>
                    <a href="{{ route('search') }}" 
                       class="block w-full text-center bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 font-semibold">
                        Reset Filters
                    </a>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3">
            <!-- Sorting -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <p class="text-gray-600 mb-4 md:mb-0">
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                    </p>
                    
                    <form action="{{ route('search') }}" method="GET" class="flex items-center">
                        <!-- Preserve existing filters -->
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
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

            <!-- Products -->
            @if($products->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h2 class="text-2xl font-semibold mb-4">No Products Found</h2>
                    <p class="text-gray-600 mb-8">Try adjusting your filters or search terms</p>
                    <a href="{{ route('search') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                        Clear All Filters
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
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
                            <a href="{{ route('shop.category', $product->category->slug) }}" 
                               class="text-sm text-indigo-600 hover:underline">
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
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection