@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8">Test Payment Cards</h1>
    
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong>Test Mode:</strong> Use these test cards for development. No real charges will be made.
                </p>
            </div>
        </div>
    </div>

    <!-- Stripe Test Cards -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center mb-6">
            <svg class="w-12 h-12 mr-4" viewBox="0 0 60 25" xmlns="http://www.w3.org/2000/svg">
                <path fill="#635BFF" d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58z"/>
            </svg>
            <h2 class="text-2xl font-bold">Stripe Test Cards</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Card Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 font-mono text-sm">4242 4242 4242 4242</td>
                        <td class="px-6 py-4">Visa</td>
                        <td class="px-6 py-4"><span class="text-green-600 font-semibold">✓ Success</span></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-sm">5555 5555 5555 4444</td>
                        <td class="px-6 py-4">Mastercard</td>
                        <td class="px-6 py-4"><span class="text-green-600 font-semibold">✓ Success</span></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-sm">3782 822463 10005</td>
                        <td class="px-6 py-4">American Express</td>
                        <td class="px-6 py-4"><span class="text-green-600 font-semibold">✓ Success</span></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-sm">4000 0000 0000 9995</td>
                        <td class="px-6 py-4">Visa</td>
                        <td class="px-6 py-4"><span class="text-red-600 font-semibold">✗ Declined (Insufficient Funds)</span></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-sm">4000 0000 0000 0002</td>
                        <td class="px-6 py-4">Visa</td>
                        <td class="px-6 py-4"><span class="text-red-600 font-semibold">✗ Declined (Generic)</span></td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-sm">4000 0025 0000 3155</td>
                        <td class="px-6 py-4">Visa</td>
                        <td class="px-6 py-4"><span class="text-yellow-600 font-semibold">⚠ Requires Authentication (3D Secure)</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-2">Additional Information:</h3>
            <ul class="space-y-1 text-sm text-gray-700">
                <li>• <strong>Expiry Date:</strong> Any future date (e.g., 12/25)</li>
                <li>• <strong>CVC:</strong> Any 3 digits (e.g., 123)</li>
                <li>• <strong>ZIP Code:</strong> Any valid format (e.g., 12345)</li>
            </ul>
        </div>
    </div>

    <!-- PayPal Test Accounts -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <svg class="w-20 h-12 mr-4" viewBox="0 0 100 32" xmlns="http://www.w3.org/2000/svg">
                <path fill="#003087" d="M12 4.917h7.322c4.469 0 7.678 1.849 7.678 6.362 0 5.326-3.794 8.684-9.166 8.684H14.45l-1.128 5.683H9.417L12 4.917z"/>
                <path fill="#009cde" d="M35 4.917h7.322c4.469 0 7.678 1.849 7.678 6.362 0 5.326-3.794 8.684-9.166 8.684H37.45l-1.128 5.683H32.417L35 4.917z"/>
            </svg>
            <h2 class="text-2xl font-bold">PayPal Sandbox Testing</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-semibold text-blue-900 mb-2">Buyer Account (Test Customer)</h3>
                <div class="space-y-1 text-sm">
                    <p><strong>Email:</strong> <code class="bg-white px-2 py-1 rounded">buyer@example.com</code></p>
                    <p><strong>Password:</strong> <code class="bg-white px-2 py-1 rounded">your_test_password</code></p>
                    <p class="text-blue-700 mt-2">Use this account to complete test purchases</p>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-semibold text-green-900 mb-2">Seller Account (Your Business)</h3>
                <div class="space-y-1 text-sm">
                    <p><strong>Email:</strong> <code class="bg-white px-2 py-1 rounded">seller@example.com</code></p>
                    <p><strong>Password:</strong> <code class="bg-white px-2 py-1 rounded">your_test_password</code></p>
                    <p class="text-green-700 mt-2">This is where test payments will be received</p>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-2">Setup Instructions:</h3>
            <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                <li>Go to <a href="https://developer.paypal.com" target="_blank" class="text-blue-600 hover:underline">developer.paypal.com</a></li>
                <li>Click on "Dashboard" and log in</li>
                <li>Go to "Sandbox" → "Accounts"</li>
                <li>Create a Business account and a Personal account</li>
                <li>Copy the credentials to your .env file</li>
                <li>Use the Personal account credentials to test purchases</li>
            </ol>
        </div>
    </div>

    <!-- Testing Checklist -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h2 class="text-2xl font-bold mb-6">Testing Checklist</h2>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-5 w-5 text-indigo-600 rounded">
                <div>
                    <p class="font-semibold">Successful Payment Flow</p>
                    <p class="text-sm text-gray-600">Test a complete purchase with a valid card</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-5 w-5 text-indigo-600 rounded">
                <div>
                    <p class="font-semibold">Declined Card Handling</p>
                    <p class="text-sm text-gray-600">Verify error messages for declined cards</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-5 w-5 text-indigo-600 rounded">
                <div>
                    <p class="font-semibold">PayPal Redirect Flow</p>
                    <p class="text-sm text-gray-600">Complete a PayPal transaction end-to-end</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-5 w-5 text-indigo-600 rounded">
                <div>
                    <p class="font-semibold">Order Confirmation</p>
                    <p class="text-sm text-gray-600">Check order appears in admin panel and user account</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-5 w-5 text-indigo-600 rounded">
                <div>
                    <p class="font-semibold">Stock Updates</p>
                    <p class="text-sm text-gray-600">Verify product stock decreases after purchase</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <input type="checkbox" class="mt-1 mr-3 h-5 w-5 text-indigo-600 rounded">
                <div>
                    <p class="font-semibold">Cart Clearing</p>
                    <p class="text-sm text-gray-600">Ensure cart is emptied after successful checkout</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection