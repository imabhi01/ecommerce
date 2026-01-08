@extends('layouts.app')

@section('content')

<!-- Contact Hero -->
<section class="bg-gradient-to-b from-blue-50 to-white py-20">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Get in <span class="text-indigo-600">Touch</span>
        </h1>
        <p class="text-gray-600">
            Have a question, collaboration idea, or event inquiry? Let’s connect.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12">

        <!-- Contact Form -->
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                Contact Form
            </h2>

            <form method="POST" action="#">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Name
                    </label>
                    <input type="text"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Message
                    </label>
                    <textarea rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                </div>

                <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Map + Info -->
        <div class="space-y-6">

            <!-- Google Map -->
            <div class="rounded-xl overflow-hidden shadow-lg h-64">
                <iframe
                    class="w-full h-full border-0"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q=London&output=embed">
                </iframe>
            </div>

            <!-- Address -->
            <div class="bg-white shadow-md rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 mb-2">
                    Location
                </h3>
                <p class="text-gray-600 text-sm">
                    London, United Kingdom
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Freebie Section -->
<section class="py-20 bg-gradient-to-b from-white to-blue-50">
    <div class="max-w-4xl mx-auto px-4 text-center">

        <h2 class="text-2xl font-bold text-gray-900 mb-4">
            🎁 Free AI Masterclass
        </h2>

        <p class="text-gray-600 mb-8">
            Download my free tutorial and learn practical AI skills
            to improve productivity and automate workflows.
        </p>

        <a href="#"
           class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold shadow hover:bg-indigo-700">
            Download Free Tutorial
        </a>

    </div>
</section>

<!-- Events Section -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">

        <h2 class="text-2xl font-bold text-gray-900 mb-10 text-center">
            Upcoming Events
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Event Card -->
            <div class="bg-white shadow-md rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 mb-2">
                    AI for Developers
                </h3>
                <p class="text-sm text-gray-600 mb-3">
                    Online Masterclass
                </p>
                <span class="text-xs text-indigo-600 font-semibold">
                    March 2026
                </span>
            </div>

            <div class="bg-white shadow-md rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 mb-2">
                    Laravel & SaaS Workshop
                </h3>
                <p class="text-sm text-gray-600 mb-3">
                    Live Webinar
                </p>
                <span class="text-xs text-indigo-600 font-semibold">
                    April 2026
                </span>
            </div>

            <div class="bg-white shadow-md rounded-xl p-6">
                <h3 class="font-semibold text-gray-800 mb-2">
                    Monetizing Digital Products
                </h3>
                <p class="text-sm text-gray-600 mb-3">
                    Community Event
                </p>
                <span class="text-xs text-indigo-600 font-semibold">
                    Coming Soon
                </span>
            </div>

        </div>

    </div>
</section>

@endsection
