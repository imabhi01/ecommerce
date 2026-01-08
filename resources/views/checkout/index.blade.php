@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Shipping Information -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">1</span>
                        Shipping Information
                    </h2>
                    
                    <form id="checkoutForm" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" 
                                       name="shipping_name" 
                                       required
                                       value="{{ auth()->user()->name ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" 
                                       name="shipping_email" 
                                       required
                                       value="{{ auth()->user()->email ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                            <input type="text" 
                                   name="shipping_address" 
                                   required
                                   placeholder="123 Main Street"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" 
                                       name="shipping_city" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State/Province *</label>
                                <input type="text" 
                                       name="shipping_state" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ZIP/Postal Code *</label>
                                <input type="text" 
                                       name="shipping_zip" 
                                       required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                            <select name="shipping_country" 
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Country</option>
                                <option value="US" selected>United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="JP">Japan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Order Notes (Optional)</label>
                            <textarea name="notes" 
                                      rows="3"
                                      placeholder="Special delivery instructions..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                        </div>
                    </form>
                </div>

                <!-- Payment Method Selection -->
                <div class="border-t pt-8">
                    <h2 class="text-2xl font-bold mb-6 flex items-center">
                        <span class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center mr-3">2</span>
                        Payment Method
                    </h2>

                    <div class="space-y-4" x-data="{ paymentMethod: 'stripe' }">
                        <!-- Stripe Option -->
                        <div class="border-2 rounded-lg p-4 cursor-pointer transition-colors"
                             :class="paymentMethod === 'stripe' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300'"
                             @click="paymentMethod = 'stripe'">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="stripe" 
                                       x-model="paymentMethod"
                                       class="w-5 h-5 text-indigo-600">
                                <span class="ml-3 flex items-center">
                                    <svg class="w-12 h-8" viewBox="0 0 60 25" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#635BFF" d="M59.64 14.28h-8.06c.19 1.93 1.6 2.55 3.2 2.55 1.64 0 2.96-.37 4.05-.95v3.32a8.33 8.33 0 0 1-4.56 1.1c-4.01 0-6.83-2.5-6.83-7.48 0-4.19 2.39-7.52 6.3-7.52 3.92 0 5.96 3.28 5.96 7.5 0 .4-.04 1.26-.06 1.48zm-5.92-5.62c-1.03 0-2.17.73-2.17 2.58h4.25c0-1.85-1.07-2.58-2.08-2.58zM40.95 20.3c-1.44 0-2.32-.6-2.9-1.04l-.02 4.63-4.12.87V5.57h3.76l.08 1.02a4.7 4.7 0 0 1 3.23-1.29c2.9 0 5.62 2.6 5.62 7.4 0 5.23-2.7 7.6-5.65 7.6zM40 8.95c-.95 0-1.54.34-1.97.81l.02 6.12c.4.44.98.78 1.95.78 1.52 0 2.54-1.65 2.54-3.87 0-2.15-1.04-3.84-2.54-3.84zM28.24 5.57h4.13v14.44h-4.13V5.57zm0-4.7L32.37 0v3.36l-4.13.88V.88zm-4.32 9.35v9.79H19.8V5.57h3.7l.12 1.22c1-1.77 3.07-1.41 3.62-1.22v3.79c-.52-.17-2.29-.43-3.32.86zm-8.55 4.72c0 2.43 2.6 1.68 3.12 1.46v3.36c-.55.3-1.54.54-2.89.54a4.15 4.15 0 0 1-4.27-4.24l.01-13.17 4.02-.86v3.54h3.14V9.1h-3.13v5.85zm-4.91.7c0 2.97-2.31 4.66-5.73 4.66a11.2 11.2 0 0 1-4.46-.93v-3.93c1.38.75 3.1 1.31 4.46 1.31.92 0 1.53-.24 1.53-1C6.26 13.77 0 14.51 0 9.95 0 7.04 2.28 5.3 5.62 5.3c1.36 0 2.72.2 4.09.75v3.88a9.23 9.23 0 0 0-4.1-1.06c-.86 0-1.44.25-1.44.93 0 1.85 6.29.97 6.29 5.88z"/>
                                    </svg>
                                    <span class="ml-3 font-medium">Credit/Debit Card</span>
                                </span>
                            </label>

                            <!-- Stripe Card Element -->
                            <div x-show="paymentMethod === 'stripe'" 
                                 x-transition
                                 class="mt-4 pt-4 border-t">
                                <div id="card-element" class="px-4 py-3 border border-gray-300 rounded-lg bg-white"></div>
                                <div id="card-errors" class="text-red-600 text-sm mt-2"></div>
                                
                                <button type="button"
                                        onclick="processStripePayment()"
                                        class="w-full mt-4 bg-indigo-600 text-white px-6 py-4 rounded-lg hover:bg-indigo-700 font-semibold text-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Pay ${{ number_format($total, 2) }}
                                </button>
                            </div>
                        </div>

                        <!-- PayPal Option -->
                        <div class="border-2 rounded-lg p-4 cursor-pointer transition-colors"
                             :class="paymentMethod === 'paypal' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300'"
                             @click="paymentMethod = 'paypal'">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="paypal" 
                                       x-model="paymentMethod"
                                       class="w-5 h-5 text-indigo-600">
                                <span class="ml-3 flex items-center">
                                    <svg class="w-20 h-8" viewBox="0 0 100 32" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#003087" d="M12 4.917h7.322c4.469 0 7.678 1.849 7.678 6.362 0 5.326-3.794 8.684-9.166 8.684H14.45l-1.128 5.683H9.417L12 4.917z"/>
                                        <path fill="#009cde" d="M35 4.917h7.322c4.469 0 7.678 1.849 7.678 6.362 0 5.326-3.794 8.684-9.166 8.684H37.45l-1.128 5.683H32.417L35 4.917z"/>
                                        <path fill="#003087" d="M67.5 4.917h-4.106l-2.583 12.729c-.233 1.248-.05 2.143.515 2.663.565.52 1.614.78 3.146.78h1.936l.669-3.373h-1.458c-.823 0-1.18-.186-1.18-.746 0-.187.034-.42.103-.7l1.498-7.48h2.64l.669-3.373h-2.64l.598-2.998-4.407.598-.598 2.4h-2.64"/>
                                        <path fill="#009cde" d="M78.417 11.65c-1.797 0-3.007 1.164-3.007 2.898 0 1.386.95 2.292 2.425 2.292 1.798 0 3.029-1.155 3.029-2.85 0-1.45-.961-2.34-2.447-2.34zm-2.436 13.996h4.106l1.044-5.198c.96.906 2.426 1.385 4.106 1.385 3.93 0 7.29-2.972 7.29-7.6 0-3.427-2.382-5.666-6.073-5.666-1.903 0-3.636.746-4.785 2.042l.244-1.692h-3.885l-2.047 16.729z"/>
                                    </svg>
                                </span>
                            </label>

                            <!-- PayPal Button -->
                            <div x-show="paymentMethod === 'paypal'" 
                                 x-transition
                                 class="mt-4 pt-4 border-t">
                                <form action="{{ route('checkout.paypal') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="shipping_name" id="paypal_shipping_name">
                                    <input type="hidden" name="shipping_email" id="paypal_shipping_email">
                                    <input type="hidden" name="shipping_address" id="paypal_shipping_address">
                                    <input type="hidden" name="shipping_city" id="paypal_shipping_city">
                                    <input type="hidden" name="shipping_state" id="paypal_shipping_state">
                                    <input type="hidden" name="shipping_zip" id="paypal_shipping_zip">
                                    <input type="hidden" name="shipping_country" id="paypal_shipping_country">
                                    
                                    <button type="submit"
                                            onclick="return copyFormData('paypal')"
                                            class="w-full bg-yellow-400 text-gray-900 px-6 py-4 rounded-lg hover:bg-yellow-500 font-semibold text-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M20.067 8.478c.492.88.556 2.014.3 3.327-.74 3.806-3.276 5.12-6.514 5.12h-.5a.805.805 0 00-.794.68l-.04.22-.63 3.993-.028.15a.804.804 0 01-.794.68H7.22a.483.483 0 01-.477-.558L7.86 17.3l1.064-6.75.037-.24a.805.805 0 01.794-.68h.5c3.238 0 5.774-1.314 6.514-5.12.256-1.313.192-2.447-.3-3.327h1.202c.42 0 .77.322.802.74.022.294.04.598.048.91.057 2.082-.005 3.717-.454 4.645z"/>
                                        </svg>
                                        Pay with PayPal
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="mt-6 flex items-center justify-center text-sm text-gray-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Secure SSL Encrypted Payment
                </div>
            </div>
        </div>

        <!-- Order Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-2xl font-bold mb-6">Order Summary</h2>

                <!-- Cart Items -->
                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                    @foreach($cartItems as $item)
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <img src="{{ $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : 'https://via.placeholder.com/60' }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-16 h-16 object-cover rounded">
                            <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $item->quantity }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm">{{ $item->product->name }}</p>
                            <p class="text-gray-600 text-sm">${{ number_format($item->product->price, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pricing -->
                <div class="border-t pt-4 space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between text-xl font-bold">
                        <span>Total</span>
                        <span class="text-indigo-600">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Promo Code -->
                <div class="mt-6">
                    <input type="text" 
                           placeholder="Promo code" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-2">
                    <button class="w-full text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                        Apply Coupon
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe JavaScript -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Initialize Stripe
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    
    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
    });
    
    cardElement.mount('#card-element');
    
    // Handle validation errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Process Stripe payment
    async function processStripePayment() {
        const form = document.getElementById('checkoutForm');
        
        // Validate form
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Create payment method
        const {paymentMethod, error} = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: form.shipping_name.value,
                email: form.shipping_email.value,
                address: {
                    line1: form.shipping_address.value,
                    city: form.shipping_city.value,
                    state: form.shipping_state.value,
                    postal_code: form.shipping_zip.value,
                    country: form.shipping_country.value
                }
            }
        });
        
        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            return;
        }
        
        // Submit to server
        const formData = new FormData(form);
        formData.append('stripeToken', paymentMethod.id);
        
        try {
            const response = await fetch('{{ route('checkout.stripe') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                const data = await response.json();
                if (data.error) {
                    document.getElementById('card-errors').textContent = data.error;
                }
            }
        } catch (err) {
            document.getElementById('card-errors').textContent = 'Payment failed. Please try again.';
        }
    }
    
    // Copy form data for PayPal
    function copyFormData(method) {
        const form = document.getElementById('checkoutForm');
        
        if (!form.checkValidity()) {
            form.reportValidity();
            return false;
        }
        
        const prefix = method + '_';
        document.getElementById(prefix + 'shipping_name').value = form.shipping_name.value;
        document.getElementById(prefix + 'shipping_email').value = form.shipping_email.value;
        document.getElementById(prefix + 'shipping_address').value = form.shipping_address.value;
        document.getElementById(prefix + 'shipping_city').value = form.shipping_city.value;
        document.getElementById(prefix + 'shipping_state').value = form.shipping_state.value;
        document.getElementById(prefix + 'shipping_zip').value = form.shipping_zip.value;
        document.getElementById(prefix + 'shipping_country').value = form.shipping_country.value;
        
        return true;
    }
</script>
@endsection