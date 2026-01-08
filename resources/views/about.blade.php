@extends('layouts.app')

@section('content')

<!-- Hero / About -->
<section class="bg-gradient-to-b from-blue-50 to-white py-20">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

        <!-- Left Content -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                About <span class="text-indigo-600">ModernShop</span>
            </h1>

            <p class="text-gray-600 mb-6">
                ModernShop is my personal platform where I sell digital products,
                write blogs, and earn online through affiliate recommendations.
            </p>

            <!-- Newsletter -->
            <div class="bg-white shadow-md rounded-xl p-5 max-w-md">
                <h3 class="font-semibold text-gray-800 mb-2">
                    Subscribe to my Newsletter
                </h3>
                <form class="flex gap-2">
                    <input type="email"
                           placeholder="Your email"
                           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Image + Tech -->
        <div class="space-y-6">

            <!-- Image Card -->
            <div class="w-64 h-64 overflow-hidden shadow-lg mx-auto"
                 style="border-radius:10%;">
                <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg"
                     alt="Author"
                     class="w-full h-full object-cover">
            </div>

            <!-- Technologies -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h4 class="font-semibold text-gray-800 mb-4 text-center">
                    Technologies & Services
                </h4>

                <div class="grid grid-cols-2 gap-3 text-sm text-gray-600">
                    <span>✔ Laravel</span>
                    <span>✔ PHP</span>
                    <span>✔ JavaScript</span>
                    <span>✔ Tailwind CSS</span>
                    <span>✔ MySQL</span>
                    <span>✔ REST APIs</span>
                    <span>✔ Stripe / PayPal</span>
                    <span>✔ SaaS Development</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Buy Me a Coffee -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">

        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            Support My Work ☕
        </h2>

        <p class="text-gray-600 mb-8">
            If you find my content or products useful, you can support me by
            buying me a coffee. It helps me create more quality resources.
        </p>

        <a href="#"
           class="inline-flex items-center gap-2 bg-yellow-400 text-gray-900 px-6 py-3 rounded-xl font-semibold shadow hover:bg-yellow-500 transition">
            ☕ Buy Me a Coffee
        </a>

    </div>
</section>

@endsection
