@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
            <div class="bg-white rounded-lg overflow-hidden mb-4">
                @if($product->images->isNotEmpty())
                    <img id="mainImage" 
                         src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-6xl">📷</span>
                    </div>
                @endif
            </div>

            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $image)
                <button onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $image->image_path) }}'"
                        class="border-2 border-transparent hover:border-indigo-600 rounded-lg overflow-hidden transition-colors">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-24 object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <nav class="text-sm text-gray-500 mb-4">
                <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Shop</a>
                <span class="mx-2">/</span>
                <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-indigo-600">
                    {{ $product->category->name }}
                </a>
            </nav>

            <h1 class="text-4xl font-bold mb-4">{{ $product->name }}</h1>

            <div class="flex items-center mb-6">
                <span class="text-4xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @if($product->compare_price)
                    <span class="text-xl text-gray-500 line-through ml-4">
                        ${{ number_format($product->compare_price, 2) }}
                    </span>
                    <span class="ml-4 bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Save {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                    </span>
                @endif
            </div>

            @if($product->stock > 0)
                <div class="mb-6">
                    <span class="inline-flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        In Stock ({{ $product->stock }} available)
                    </span>
                </div>
            @else
                <div class="mb-6">
                    <span class="inline-flex items-center text-red-600">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Out of Stock
                    </span>
                </div>
            @endif

            <div class="prose max-w-none mb-8">
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>

            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <input type="number" 
                           name="quantity" 
                           value="1" 
                           min="1" 
                           max="{{ $product->stock }}"
                           class="w-32 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-indigo-600 text-white px-8 py-4 rounded-lg hover:bg-indigo-700 transition-colors font-semibold text-lg">
                        Add to Cart
                    </button>
                </div>
            </form>
            @endif

            <!-- Wishlist Button -->
            <div class="flex flex-col space-y-2 mt-4">
                <x-wishlist-button :product="$product" classes="px-6 py-4 border-2 border-gray-300 rounded-lg hover:border-indigo-600 transition-colors flex items-center justify-center" />
                <span class="text-xs text-center text-gray-600">Add to Wishlist</span>
            </div>

            <!-- Product Details -->
            <div class="mt-8 border-t pt-8">
                <h3 class="text-lg font-semibold mb-4">Product Details</h3>
                <dl class="space-y-2">
                    <div class="flex">
                        <dt class="font-medium text-gray-600 w-32">SKU:</dt>
                        <dd class="text-gray-900">{{ $product->sku }}</dd>
                    </div>
                    <div class="flex">
                        <dt class="font-medium text-gray-600 w-32">Category:</dt>
                        <dd>
                            <a href="{{ route('shop.category', $product->category->slug) }}" 
                               class="text-indigo-600 hover:underline">
                                {{ $product->category->name }}
                            </a>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold">Customer Reviews</h2>
                    @if($product->totalReviews() > 0)
                    <div class="flex items-center mt-2">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($product->averageRating()))
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">
                            {{ number_format($product->averageRating(), 1) }} out of 5 ({{ $product->totalReviews() }} reviews)
                        </span>
                    </div>
                    @endif
                </div>
                
                @auth
                    @php
                        $userReview = $product->reviews()->where('user_id', auth()->id())->first();
                        $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                            ->where('status', 'delivered')
                            ->whereHas('items', function($query) use ($product) {
                                $query->where('product_id', $product->id);
                            })
                            ->exists();
                    @endphp
                    
                    @if(!$userReview && $hasPurchased)
                        <button onclick="document.getElementById('review-form').scrollIntoView({ behavior: 'smooth' })"
                                class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-semibold">
                            Write a Review
                        </button>
                    @endif
                @endauth
            </div>

            <!-- Review List -->
            <div class="space-y-6 mb-12">
                @forelse($product->approvedReviews()->latest()->get() as $review)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold">{{ $review->user->name }}</p>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                    @if($review->verified_purchase)
                                        <span class="ml-2 text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                            ✓ Verified Purchase
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">{{ $review->created_at->diffForHumans() }}</p>
                            @if($review->user_id === auth()->id())
                                <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Delete this review?')"
                                            class="text-red-600 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    
                    <h4 class="font-semibold text-lg mb-2">{{ $review->title }}</h4>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                </div>
                @empty
                <div class="bg-gray-50 rounded-lg p-12 text-center">
                    <p class="text-gray-600 text-lg">No reviews yet. Be the first to review this product!</p>
                </div>
                @endforelse
            </div>

            <!-- Write Review Form -->
            @auth
                @if(!$userReview && $hasPurchased)
                <div id="review-form" class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4">Write a Review</h3>
                    
                    <form action="{{ route('reviews.store', $product) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Rating *</label>
                                <div class="flex items-center space-x-2" x-data="{ rating: 0 }">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button" @click="rating = {{ $i }}" class="focus:outline-none">
                                            <svg class="w-8 h-8 transition-colors"
                                                :class="rating >= {{ $i }} ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'"
                                                viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                    </button>
                                    @endfor
                                    <input type="hidden" name="rating" x-model="rating" required>
                                </div>
                                @error('rating')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Review Title *</label>
                                <input type="text" 
                                    name="title" 
                                    value="{{ old('title') }}"
                                    required
                                    maxlength="255"
                                    placeholder="Sum up your experience"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Your Review *</label>
                                <textarea name="comment" 
                                        rows="5"
                                        required
                                        maxlength="1000"
                                        placeholder="Tell us what you think about this product"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('comment') border-red-500 @enderror">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" 
                                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-semibold">
                                Submit Review
                            </button>
                        </form>
                    </div>
                    @elseif($userReview)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                        <p class="text-blue-900">You have already reviewed this product. Thank you for your feedback!</p>
                    </div>
                    @elseif(!$hasPurchased)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <p class="text-yellow-900">You need to purchase this product before you can leave a review.</p>
                    </div>
                    @endif
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <p class="text-gray-700">
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Log in</a> 
                            to write a review
                        </p>
                    </div>
            @endauth
        </div>
        <!-- Related Products -->
        @if($relatedProducts->isNotEmpty())
        <div class="mt-16">
            <h2 class="text-3xl font-bold mb-8">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <a href="{{ route('shop.show', $relatedProduct->slug) }}">
                        @if($relatedProduct->primaryImage)
                            <img src="{{ asset('storage/' . $relatedProduct->primaryImage->image_path) }}" 
                                alt="{{ $relatedProduct->name }}" 
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-3xl">📷</span>
                            </div>
                        @endif
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2 truncate">
                            <a href="{{ route('shop.show', $relatedProduct->slug) }}" class="hover:text-indigo-600">
                                {{ $relatedProduct->name }}
                            </a>
                        </h3>
                        <p class="text-xl font-bold">${{ number_format($relatedProduct->price, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection