@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold">My Wishlist</h1>
            <p class="text-gray-600 mt-2">{{ $wishlistItems->count() }} items saved</p>
        </div>
        
        @if($wishlistItems->isNotEmpty())
        <form action="{{ route('wishlist.clear') }}" method="POST" onsubmit="return confirm('Clear entire wishlist?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                Clear All
            </button>
        </form>
        @endif
    </div>

    @if($wishlistItems->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h2 class="text-2xl font-semibold mb-4">Your wishlist is empty</h2>
            <p class="text-gray-600 mb-8">Save items you love by clicking the heart icon</p>
            <a href="{{ route('shop.index') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 inline-block font-semibold">
                Start Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow relative">
                <!-- Remove Button -->
                <button onclick="toggleWishlist({{ $item->product->id }}, this)"
                        class="absolute top-2 right-2 z-10 bg-white rounded-full p-2 shadow-md hover:bg-red-50 transition-colors">
                    <svg class="w-6 h-6 text-red-600 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>

                <!-- Product Image -->
                <a href="{{ route('shop.show', $item->product->slug) }}">
                    @if($item->product->primaryImage)
                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" 
                             alt="{{ $item->product->name }}" 
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400 text-4xl">📷</span>
                        </div>
                    @endif
                </a>

                <!-- Product Info -->
                <div class="p-4">
                    <a href="{{ route('shop.category', $item->product->category->slug) }}" 
                       class="text-sm text-indigo-600 hover:underline">
                        {{ $item->product->category->name }}
                    </a>
                    <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                        <a href="{{ route('shop.show', $item->product->slug) }}" class="hover:text-indigo-600">
                            {{ $item->product->name }}
                        </a>
                    </h3>

                    <!-- Price -->
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">${{ number_format($item->product->price, 2) }}</span>
                            @if($item->product->compare_price)
                                <span class="text-sm text-gray-500 line-through ml-2">
                                    ${{ number_format($item->product->compare_price, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Status -->
                    @if($item->product->stock > 0)
                        <p class="text-sm text-green-600 mb-4">✓ In Stock</p>
                    @else
                        <p class="text-sm text-red-600 mb-4">Out of Stock</p>
                    @endif

                    <!-- Actions -->
                    <div class="flex space-x-2">
                        @if($item->product->stock > 0)
                            <form action="{{ route('wishlist.move-to-cart', $item) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors text-sm font-semibold">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed text-sm font-semibold">
                                Out of Stock
                            </button>
                        @endif
                        <a href="{{ route('shop.show', $item->product->slug) }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-semibold">
                            View
                        </a>
                    </div>
                </div>

                <!-- Date Added -->
                <div class="px-4 pb-4">
                    <p class="text-xs text-gray-500">Added {{ $item->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Share Wishlist -->
        <div class="mt-12 bg-white rounded-lg shadow-md p-6 text-center">
            <h3 class="text-xl font-bold mb-4">Share Your Wishlist</h3>
            <p class="text-gray-600 mb-4">Let others know what you love!</p>
            <div class="flex justify-center space-x-4">
                <button onclick="shareWishlist('facebook')" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                    Share on Facebook
                </button>
                <button onclick="shareWishlist('twitter')" 
                        class="bg-sky-500 text-white px-6 py-2 rounded-lg hover:bg-sky-600 font-semibold">
                    Share on Twitter
                </button>
                <button onclick="copyWishlistLink()" 
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 font-semibold">
                    Copy Link
                </button>
            </div>
        </div>
    @endif
</div>

<script>
function toggleWishlist(productId, button) {
    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the product card
            button.closest('.relative').remove();
            
            // Update wishlist count in header
            updateWishlistCount(data.wishlist_count);
            
            // Show message
            showNotification(data.message);
            
            // Check if wishlist is empty
            if (data.wishlist_count === 0) {
                location.reload();
            }
        }
    });
}

function updateWishlistCount(count) {
    const badge = document.querySelector('#wishlist-count');
    if (badge) {
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }
}

function shareWishlist(platform) {
    const url = window.location.href;
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=Check out my wishlist!`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

function copyWishlistLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showNotification('Link copied to clipboard!');
    });
}

function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection