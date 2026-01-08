<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ModernShop') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        ModernShop
                    </a>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                            Shop
                        </a>
                        <a href="#" class="text-gray-700 hover:text-indigo-600 px-3 py-2">
                            Categories
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <!-- <div class="hidden md:block">
                        <input type="text" placeholder="Search products..." 
                               class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div> -->

                    <!-- Advanced Search -->
                    <div class="hidden md:block relative" x-data="{ open: false, query: '', results: [] }">
                        <input type="text" 
                            x-model="query"
                            @input.debounce.300ms="
                                if (query.length > 2) {
                                    fetch('/api/search/autocomplete?q=' + encodeURIComponent(query))
                                        .then(r => r.json())
                                        .then(data => { results = data; open = true; });
                                } else {
                                    results = [];
                                    open = false;
                                }
                            "
                            @click.away="open = false"
                            @keydown.escape="open = false; query = ''"
                            @keydown.enter="window.location.href = '/search?q=' + encodeURIComponent(query)"
                            placeholder="Search products..." 
                            class="w-64 px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        
                        <button @click="window.location.href = '/search?q=' + encodeURIComponent(query)"
                                class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>

                        <!-- Autocomplete Dropdown -->
                        <div x-show="open && results.length > 0"
                            x-transition
                            class="absolute top-full mt-2 w-96 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                            <template x-for="product in results" :key="product.id">
                                <a :href="'/shop/' + product.slug" 
                                class="flex items-center p-3 hover:bg-gray-50 border-b last:border-b-0">
                                    <img :src="product.image || 'https://via.placeholder.com/60'" 
                                        :alt="product.name"
                                        class="w-16 h-16 object-cover rounded">
                                    <div class="ml-3 flex-1">
                                        <p class="font-semibold text-gray-900" x-text="product.name"></p>
                                        <p class="text-sm text-gray-600" x-text="product.category"></p>
                                    </div>
                                    <p class="font-bold text-indigo-600" x-text="'$' + product.price.toFixed(2)"></p>
                                </a>
                            </template>
                            <a :href="'/search?q=' + encodeURIComponent(query)"
                            class="block p-3 text-center text-indigo-600 hover:bg-gray-50 font-semibold">
                                View all results →
                            </a>
                        </div>
                    </div>
                    
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @php
                            $cartCount = \App\Models\Cart::where(function($query) {
                                $query->where('user_id', auth()->id())
                                      ->orWhere('session_id', session()->getId());
                            })->sum('quantity');
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-indigo-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Wishlist Icon -->
                    @auth
                    <a href="{{ route('wishlist.index') }}" class="relative text-gray-700 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        @php
                            $wishlistCount = auth()->user()->wishlist()->count();
                        @endphp
                        @if($wishlistCount > 0)
                            <span id="wishlist-count" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                {{ $wishlistCount }}
                            </span>
                        @endif
                    </a>
                    @endauth
                    
                    <!-- User Menu -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    My Orders
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">ModernShop</h3>
                    <p class="text-gray-400">Your trusted online marketplace for quality products.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white">All Products</a></li>
                        <li><a href="#" class="hover:text-white">New Arrivals</a></li>
                        <li><a href="#" class="hover:text-white">Best Sellers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">FAQs</a></li>
                        <li><a href="#" class="hover:text-white">Shipping Info</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 ModernShop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>