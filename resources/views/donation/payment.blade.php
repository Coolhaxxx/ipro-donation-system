@extends('layouts.app')

@section('title', 'Complete Your Payment')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        
        <div class="bg-white rounded-lg shadow-2xl p-8">
            
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Complete Your Payment</h1>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Donation Type:</span>
                        <span class="font-semibold">{{ $donation->donation_type_name }}</span>
                    </div>
                    <div class="flex justify-between border-t pt-3">
                        <span class="text-gray-600 text-lg">Total Amount:</span>
                        <span class="font-bold text-2xl text-green-600">{{ $donation->formatted_amount }}</span>
                    </div>
                </div>
            </div>

            <!-- Stripe Payment Form Placeholder -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Payment Information</h3>
                
                <!-- This will be replaced with Stripe Elements -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 text-blue-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Stripe Integration Coming Soon</h3>
                    <p class="text-gray-600 mb-6">
                        Secure payment processing will be integrated in the next step.
                        For now, your donation has been recorded.
                    </p>
                    <a href="{{ route('donation.confirmation', $donation->id) }}" 
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        Continue to Confirmation
                    </a>
                </div>
            </div>

            <!-- Security Badges -->
            <div class="border-t pt-6">
                <div class="flex items-center justify-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Secure SSL Encryption</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>PCI Compliant</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('donation.form') }}" class="text-white hover:text-gray-200">
                ← Back to Donation Form
            </a>
        </div>

    </div>
</div>
@endsection
