@props(['product', 'classes' => ''])

@auth
    <button onclick="toggleWishlist({{ $product->id }}, this)" 
            class="{{ $classes }} wishlist-btn"
            data-product-id="{{ $product->id }}"
            data-in-wishlist="{{ auth()->user()->hasInWishlist($product->id) ? 'true' : 'false' }}">
        <svg class="w-6 h-6 transition-colors {{ auth()->user()->hasInWishlist($product->id) ? 'text-red-600 fill-current' : 'text-gray-400' }}" 
             viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    </button>
@else
    <a href="{{ route('login') }}" 
       class="{{ $classes }}"
       title="Login to add to wishlist">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
    </a>
@endauth

@auth
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
            const svg = button.querySelector('svg');
            
            if (data.in_wishlist) {
                svg.classList.add('text-red-600', 'fill-current');
                svg.classList.remove('text-gray-400');
                button.dataset.inWishlist = 'true';
            } else {
                svg.classList.remove('text-red-600', 'fill-current');
                svg.classList.add('text-gray-400');
                button.dataset.inWishlist = 'false';
            }
            
            // Update wishlist count
            updateWishlistCount(data.wishlist_count);
            
            // Show notification
            showNotification(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Something went wrong', 'error');
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

function showNotification(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endauth