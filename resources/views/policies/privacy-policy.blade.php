@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('page-navigation')
    <a href="{{ route('privacy-policy') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-indigo-600 text-white">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
        <span class="text-sm sm:text-base">Privacy Policy</span>
    </a>
    <a href="{{ route('terms-conditions') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-gray-100 text-gray-700 hover:bg-gray-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span class="text-sm sm:text-base">Terms & Conditions</span>
    </a>
    <a href="{{ route('refund-policy') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-gray-100 text-gray-700 hover:bg-gray-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        <span class="text-sm sm:text-base">Refund Policy</span>
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 lg:p-12">
        <!-- Page Header -->
        <div class="mb-8 sm:mb-12">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">Privacy Policy</h1>
            </div>
            <p class="text-sm text-gray-500">Last Updated: January 24, 2026</p>
        </div>

        <!-- Content Sections -->
        <div class="space-y-8">
            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Information We Collect</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    At ModernShop, we collect information that you provide directly to us when creating an account, making purchases, or contacting our support team. This includes your name, email address, shipping address, payment information, and purchase history. We also automatically collect certain information about your device and how you interact with our platform, including IP address, browser type, operating system, and browsing behavior on our site.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">How We Use Your Information</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    We use the information we collect to process and fulfill your orders, communicate with you about your purchases and account, provide customer support, and improve our products and services. Your payment information is used solely for processing transactions and is encrypted and stored securely. We may also use your email address to send you promotional materials, but you can opt out of these communications at any time through your account settings or by clicking the unsubscribe link in our emails.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Information Sharing and Disclosure</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    We do not sell, rent, or share your personal information with third parties for their marketing purposes. We may share your information with service providers who assist us in operating our platform, processing payments, and delivering products to you. These service providers are contractually obligated to protect your information and use it only for the purposes we specify. We may also disclose your information if required by law, to protect our rights, or in connection with a business transaction such as a merger or acquisition.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Data Security</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    We implement industry-standard security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. This includes encryption of sensitive data, secure socket layer (SSL) technology for data transmission, and regular security audits. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security of your information.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Your Rights and Choices</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    You have the right to access, update, or delete your personal information at any time through your account settings. You can also request a copy of the data we hold about you by contacting our support team. If you wish to close your account, you may do so through your account settings, and we will delete your personal information in accordance with our data retention policies and legal obligations.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Cookies and Tracking Technologies</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    We use cookies and similar tracking technologies to enhance your browsing experience, analyze site traffic, and personalize content. You can control cookie settings through your browser preferences, though disabling cookies may affect the functionality of certain features on our site.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Contact Us</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    If you have questions or concerns about our privacy practices, please contact us at privacy@modernshop.com or through our contact page.
                </p>
            </section>
        </div>

        <!-- Footer Note -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-600 text-center">
                If you have any questions about this policy, please contact us at 
                <a href="mailto:support@modernshop.com" class="text-indigo-600 hover:text-indigo-700 font-medium">support@modernshop.com</a>
            </p>
        </div>
    </div>
</div>
@endsection