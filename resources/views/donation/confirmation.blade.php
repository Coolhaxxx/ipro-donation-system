@extends('layouts.app')

@section('title', 'Thank You for Your Donation')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-900 to-blue-800 py-12 px-4">
    <div class="max-w-3xl mx-auto">
        
        <!-- Success Card -->
        <div class="bg-white rounded-lg shadow-2xl p-8 md:p-12">
            
            <!-- Success Icon -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Thank You Message -->
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">
                Thank You for Your Donation!
            </h1>
            
            <p class="text-center text-gray-600 mb-8">
                Your generosity will make a difference in the lives of those affected by the Jamaica Hurricane.
            </p>

            @if(session('success'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <p class="text-blue-800">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Donation Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Donation Details</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Donation ID:</span>
                        <span class="font-semibold">#{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Donor Name:</span>
                        <span class="font-semibold">{{ $donation->donor->name }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-semibold">{{ $donation->donor->email }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-bold text-2xl text-green-600">{{ $donation->formatted_amount }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Donation Type:</span>
                        <span class="font-semibold">{{ $donation->donation_type_name }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-semibold">{{ $donation->payment_method_name }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            @if($donation->payment_status === 'completed') bg-green-100 text-green-800
                            @elseif($donation->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($donation->payment_status) }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span class="font-semibold">{{ $donation->created_at->format('F d, Y g:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method Specific Information -->
            @if($donation->payment_method === 'cash')
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
                <h3 class="font-bold text-yellow-800 mb-2">Next Steps:</h3>
                <p class="text-yellow-700">Please visit our office to complete your cash donation. Bring this confirmation for reference.</p>
            </div>
            @elseif($donation->payment_method === 'check')
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <h3 class="font-bold text-blue-800 mb-2">Check Processing:</h3>
                <p class="text-blue-700">We have received your check information. Our team will process it within 3-5 business days. You will receive a confirmation email once processed.</p>
                @if($donation->check_number)
                <p class="text-blue-700 mt-2">Check Number: <span class="font-semibold">{{ $donation->check_number }}</span></p>
                @endif
            </div>
            @elseif($donation->payment_method === 'online')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                <h3 class="font-bold text-green-800 mb-2">Payment Confirmation:</h3>
                <p class="text-green-700">Your online payment has been processed successfully. A receipt has been sent to your email address.</p>
                @if($donation->transaction_id)
                <p class="text-green-700 mt-2">Transaction ID: <span class="font-semibold">{{ $donation->transaction_id }}</span></p>
                @endif
            </div>
            @endif

            <!-- Email Confirmation Note -->
            <div class="text-center mb-8">
                <p class="text-gray-600">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    A confirmation email has been sent to <strong>{{ $donation->donor->email }}</strong>
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="{{ route('donation.form') }}" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-center transition">
                    Make Another Donation
                </a>
                <button onclick="window.print()" 
                    class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition">
                    Print Receipt
                </button>
            </div>

            <!-- Social Share -->
            <div class="text-center mt-8 pt-8 border-t">
                <p class="text-gray-600 mb-4">Help us spread the word:</p>
                <div class="flex justify-center gap-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="text-blue-400 hover:text-blue-600">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Organization Info -->
        <div class="text-center text-white mt-8">
            <p class="text-sm">Helping Hand for Relief and Development</p>
            <p class="text-sm mt-2">1-888-808-4357 (HELP) | HHRD.org</p>
            <p class="text-sm mt-2">Tax ID: 31-1628040</p>
        </div>

    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .bg-white, .bg-white * {
            visibility: visible;
        }
        .bg-white {
            position: absolute;
            left: 0;
            top: 0;
        }
        button, a {
            display: none !important;
        }
    }
</style>
@endpush

@endsection
