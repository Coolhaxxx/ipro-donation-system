@extends('admin.layout')

@section('title', 'Donor Details')

@section('content')
<div class="space-y-6">
    
    <!-- Back Button -->
    <a href="{{ route('admin.donors') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
        ← Back to Donors
    </a>

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">Donor Profile</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Donor Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl font-bold text-blue-600">{{ substr($donor->name, 0, 1) }}</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $donor->name }}</h3>
                    <p class="text-gray-600 text-sm">Donor ID: #{{ str_pad($donor->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div class="border-t pt-4 space-y-3">
                    <div>
                        <span class="text-gray-600 text-sm">Email:</span>
                        <p class="font-semibold">{{ $donor->email }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">Phone:</span>
                        <p class="font-semibold">{{ $donor->phone }}</p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">Address:</span>
                        <p class="font-semibold">
                            {{ $donor->street_address }}<br>
                            {{ $donor->city }}, {{ $donor->state }} {{ $donor->zip }}
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-600 text-sm">Member Since:</span>
                        <p class="font-semibold">{{ $donor->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
                <h4 class="font-bold text-gray-800 mb-4">Statistics</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Donations:</span>
                        <span class="font-bold text-2xl text-green-600">${{ number_format($donor->total_donations, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Number of Donations:</span>
                        <span class="font-bold text-xl text-blue-600">{{ $donor->donation_count }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donation History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Donation History</h3>
                
                <div class="space-y-4">
                    @forelse($donor->donations as $donation)
                    <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="font-bold text-2xl text-green-600">{{ $donation->formatted_amount }}</span>
                                <span class="ml-2 inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    @if($donation->payment_status === 'completed') bg-green-100 text-green-800
                                    @elseif($donation->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($donation->payment_status) }}
                                </span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $donation->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Type:</span>
                                <p class="font-semibold">{{ $donation->donation_type_name }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Method:</span>
                                <p class="font-semibold">{{ $donation->payment_method_name }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Campaign:</span>
                                <p class="font-semibold">{{ $donation->campaign }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('admin.donations.show', $donation->id) }}" 
                                class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                View Full Details →
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 py-8">No donations found for this donor.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
