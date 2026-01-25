@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('page-navigation')
    <a href="{{ route('privacy-policy') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-gray-100 text-gray-700 hover:bg-gray-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
        <span class="text-sm sm:text-base">Privacy Policy</span>
    </a>
    <a href="{{ route('terms-conditions') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-indigo-600 text-white">
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
        <div class="mb-8 sm:mb-12">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">Terms & Conditions</h1>
            </div>
            <p class="text-sm text-gray-500">Last Updated: January 24, 2026</p>
        </div>

        <div class="space-y-8">
            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Agreement to Terms</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    By accessing and using ModernShop, you agree to be bound by these Terms and Conditions and all applicable laws and regulations. If you do not agree with any part of these terms, you may not use our services. These terms apply to all visitors, users, and others who access or use our platform.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Account Registration</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    To access certain features of ModernShop, you must create an account. You agree to provide accurate, current, and complete information during registration and to update your information as necessary. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You must notify us immediately of any unauthorized use of your account.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Product Information and Pricing</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    We strive to provide accurate product descriptions, images, and pricing information. However, we do not warrant that product descriptions, pricing, or other content on our site is accurate, complete, or error-free. We reserve the right to correct any errors, inaccuracies, or omissions and to change or update information at any time without prior notice. All prices are in USD unless otherwise stated and are subject to change without notice.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Orders and Payment</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    By placing an order, you are making an offer to purchase products subject to these terms. We reserve the right to refuse or cancel any order for any reason, including product availability, errors in pricing or product information, or suspected fraud. Payment must be received before we process your order. We accept major credit cards, debit cards, and other payment methods as indicated on our site.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Digital Products and Downloads</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    Digital products purchased from ModernShop are for personal use only unless otherwise specified. You may not reproduce, distribute, modify, or create derivative works from our digital products without express written permission. Upon purchase, you will receive immediate access to download digital products. All sales of digital products are final unless otherwise stated in our Refund Policy.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Intellectual Property</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    All content on ModernShop, including text, graphics, logos, images, and software, is the property of ModernShop or its content suppliers and is protected by copyright, trademark, and other intellectual property laws. You may not use, copy, reproduce, or distribute any content from our site without our express written permission.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">User Conduct</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    You agree not to use ModernShop for any unlawful purpose or in any way that could damage, disable, or impair our services. Prohibited activities include attempting to gain unauthorized access to our systems, transmitting viruses or malicious code, engaging in fraudulent activities, or harassing other users.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Limitation of Liability</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    To the maximum extent permitted by law, ModernShop shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of or inability to use our services. Our total liability for any claim related to our services shall not exceed the amount you paid for the product or service in question.
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Changes to Terms</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    We reserve the right to modify these Terms and Conditions at any time. Changes will be effective immediately upon posting to our site. Your continued use of ModernShop after changes are posted constitutes your acceptance of the modified terms.
                </p>
            </section>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-600 text-center">
                If you have any questions about this policy, please contact us at 
                <a href="mailto:support@modernshop.com" class="text-indigo-600 hover:text-indigo-700 font-medium">support@modernshop.com</a>
            </p>
        </div>
    </div>
</div>
@endsection
