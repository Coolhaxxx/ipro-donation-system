@extends('layouts.app')

@section('title', 'Complete Payment')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Complete Your Donation</h1>

        <div class="grid md:grid-cols-2 gap-6">
            
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Donation Type:</span>
                        <span class="font-semibold">{{ $donation->donation_type_name }}</span>
                    </div>
                    <div class="flex justify-between border-t pt-3">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-bold text-2xl text-green-600">{{ $donation->formatted_amount }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-bold text-gray-800 mb-2">Donor Information</h3>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>{{ $donation->donor->name }}</p>
                        <p>{{ $donation->donor->email }}</p>
                        <p>{{ $donation->donor->phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Payment Details</h2>
                
                <form id="payment-form" action="{{ route('donation.process-payment', $donation->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Details</label>
                        <!-- Stripe Payment Element -->
                        <div id="payment-element" class="mb-4"></div>
                        
                        <!-- Error Messages -->
                        <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4"></div>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" required class="w-4 h-4 text-blue-600">
                            <span class="ml-2 text-sm text-gray-700">I agree to the terms and conditions</span>
                        </label>
                    </div>

                    <button type="submit" id="submit-button"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                        <span id="button-text">Pay {{ $donation->formatted_amount }}</span>
                        <span id="spinner" class="hidden">Processing...</span>
                    </button>
                </form>

                <div class="mt-4 text-center text-sm text-gray-500">
                    <p>🔒 Secure payment powered by Stripe</p>
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const clientSecret = '{{ $clientSecret }}';

    const options = {
        clientSecret: clientSecret,
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#2563eb',
            },
        },
    };

    // Set up Stripe.js and Elements to use in checkout form
    const elements = stripe.elements(options);

    // Create and mount the Payment Element
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');

        const { error } = await stripe.confirmPayment({
            //`elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: '{{ route("donation.process-payment", $donation->id) }}',
                payment_method_data: {
                    billing_details: {
                        name: '{{ $donation->donor->name }}',
                        email: '{{ $donation->donor->email }}',
                        phone: '{{ $donation->donor->phone }}',
                        address: {
                            line1: '{{ $donation->donor->street_address }}',
                            city: '{{ $donation->donor->city }}',
                            state: '{{ $donation->donor->state }}',
                            postal_code: '{{ $donation->donor->zip }}',
                            country: 'US', // Assuming US for now based on fields
                        }
                    }
                }
            },
        });

        if (error) {
            // This point will only be reached if there is an immediate error when
            // confirming the payment. Show error to your customer (e.g., payment
            // details incomplete)
            const messageContainer = document.querySelector('#error-message');
            messageContainer.textContent = error.message;
            messageContainer.classList.remove('hidden');
            
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        } else {
            // Your customer will be redirected to your `return_url`. For some payment
            // methods like iDEAL, your customer will be redirected to an intermediate
            // site first to authorize the payment, then redirected to the `return_url`.
        }
    });
</script>
@endpush

@endsection
