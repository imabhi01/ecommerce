@extends('layouts.app')

@section('title', 'Refund Policy')

@section('page-navigation')
    <a href="{{ route('privacy-policy') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-gray-100 text-gray-700 hover:bg-gray-200">
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
    <a href="{{ route('refund-policy') }}" class="flex items-center space-x-2 px-4 py-3 rounded-lg font-medium transition-colors mb-2 sm:mb-0 bg-indigo-600 text-white">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">Refund Policy</h1>
            </div>
            <p class="text-sm text-gray-500">Last Updated: January 24, 2026</p>
        </div>              
        <div class="space-y-8">
            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Returns and Refunds</h2>       
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    At ModernShop, we want you to be completely satisfied with your purchase. If you are not satisfied, you may return most items within 30 days of receipt for a full refund or exchange. To be eligible for a return, the item must be unused, in its original packaging, and accompanied by the original receipt or proof of purchase. Certain items, such as perishable goods, personalized products, and digital downloads, are not eligible for return.   
                </p>
            </section>

            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Return Process</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    To initiate a return, please contact our customer support team at           
                    <a href="mailto:support@modernshop.com" class="text-indigo-600 hover:underline">support@modernshop.com</a>. Provide your order number and the reason for the return. Our team will guide you through the return process and provide you with a return authorization if applicable. Please note that you may be responsible for return shipping costs unless the return is due to our error or a defective product.
                </p>
            </section>      
            <section class="border-l-4 border-indigo-600 pl-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 mb-4">Refund Processing</h2>
                <p class="text-base sm:text-lg text-gray-700 leading-relaxed">
                    Once we receive your returned item, we will inspect it to ensure it meets the return criteria. If approved, we will process your refund to the original payment method within 7-10 business days. Please note that it may take additional time for your bank or credit card company to post the
                    refund to your account. If you receive a refund for an item that was part of a promotional offer, the refund amount may be adjusted accordingly.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection