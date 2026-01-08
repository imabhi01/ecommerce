@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Elevate Your Life with
                <span class="text-indigo-600">Digital Essentials</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Discover our curated collection of ebooks, planners, and templates designed to help you achieve your goals and transform your productivity.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('shop.index') }}" 
                   class="bg-indigo-600 text-white px-8 py-4 rounded-lg hover:bg-indigo-700 font-semibold text-lg shadow-lg hover:shadow-xl transition-all">
                    Browse Collection →
                </a>
                <a href="#features" 
                   class="bg-white text-indigo-600 px-8 py-4 rounded-lg hover:bg-gray-50 font-semibold text-lg border-2 border-indigo-600 transition-all">
                    Learn More
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="text-center bg-white rounded-lg p-6 shadow-md">
                <p class="text-4xl font-bold text-indigo-600">{{ \App\Models\Product::where('is_active', true)->count() }}+</p>
                <p class="text-gray-600 mt-2">Digital Products</p>
            </div>
            <div class="text-center bg-white rounded-lg p-6 shadow-md">
                <p class="text-4xl font-bold text-indigo-600">{{ \App\Models\User::where('is_admin', false)->count() }}K+</p>
                <p class="text-gray-600 mt-2">Happy Customers</p>
            </div>
            <div class="text-center bg-white rounded-lg p-6 shadow-md">
                <p class="text-4xl font-bold text-indigo-600">4.9</p>
                <p class="text-gray-600 mt-2">Average Rating</p>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-600 font-semibold mb-2">CATEGORIES</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Explore Our Collection</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                From digital planners to productivity templates and inspiring ebooks, we've curated everything you need to succeed.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach(\App\Services\CacheService::getCategories()->take(3) as $category)
            <div class="bg-blue-50 rounded-2xl p-8 hover:shadow-xl transition-shadow">
                <div class="bg-white rounded-lg p-4 inline-block mb-6">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="w-16 h-16 object-cover">
                    @else
                        <div class="text-5xl">📚</div>
                    @endif
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $category->name }}</h3>
                <p class="text-gray-600 mb-6">{{ Str::limit($category->description, 100) }}</p>
                <a href="{{ route('shop.category', $category->slug) }}" 
                   class="text-indigo-600 font-semibold hover:text-indigo-700 inline-flex items-center">
                    Explore {{ $category->name }} →
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Featured Products -->
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <p class="text-indigo-600 font-semibold mb-2">BEST SELLERS</p>
                <h2 class="text-4xl font-bold text-gray-900">Top Picks for You</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                View All Products →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach(\App\Services\CacheService::getFeaturedProducts(4) as $product)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all group">
                <div class="relative overflow-hidden">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-64 bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                <span class="text-6xl">📦</span>
                            </div>
                        @endif
                    </a>
                    @if($product->compare_price)
                        <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            SALE
                        </span>
                    @endif
                </div>
                
                <div class="p-6">
                    <p class="text-sm text-indigo-600 font-semibold mb-2">{{ $product->category->name }}</p>
                    <h3 class="font-bold text-lg mb-2 line-clamp-2">
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
                                    class="w-full bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 px-4 py-3 rounded-lg cursor-not-allowed font-semibold">
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Why Choose Us Section -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-indigo-600 font-semibold mb-2">WHY CHOOSE US</p>
            <h2 class="text-4xl font-bold text-gray-900 mb-4">The ModernShop Difference</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                We're committed to delivering exceptional products and experiences that help you achieve your goals.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Instant Download</h3>
                <p class="text-gray-600">
                    Get immediate access to your purchase. No waiting - all your digital products are instantly ready to use.
                </p>
            </div>

            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Secure Payments</h3>
                <p class="text-gray-600">
                    Your information is protected with industry-standard encryption and secure payment processing.
                </p>
            </div>

            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Quality Products</h3>
                <p class="text-gray-600">
                    Every product is carefully curated and tested to ensure the highest quality for our customers.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-br from-gray-50 to-indigo-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-black mb-4">Ready to Get Started?</h2>
        <p class="text-xl text-black-500 mb-8">
            Join thousands of satisfied customers and transform your productivity today.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('shop.index') }}" 
               class="bg-white text-indigo-600 px-8 py-4 rounded-lg hover:bg-gray-100 font-semibold text-lg shadow-lg">
                Browse Products
            </a>
            <a href="{{ route('register') }}" 
               class="bg-indigo-800 text-white px-8 py-4 rounded-lg hover:bg-indigo-900 font-semibold text-lg">
                Create Account
            </a>
        </div>
    </div>
</div>
@endsection