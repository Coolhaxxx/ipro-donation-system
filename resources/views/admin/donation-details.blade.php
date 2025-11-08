@extends('admin.layout')

@section('title', 'Donation Details')

@section('content')
<div class="space-y-6">
    
    <!-- Back Button -->
    <a href="{{ route('admin.donations') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
        ← Back to Donations
    </a>

    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">Donation Details #{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }}</h2>
        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
            @if($donation->payment_status === 'completed') bg-green-100 text-green-800
            @elseif($donation->payment_status === 'pending') bg-yellow-100 text-yellow-800
            @else bg-red-100 text-red-800
            @endif">
            {{ ucfirst($donation->payment_status) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Donation Information -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Donation Information</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount:</span>
                    <span class="font-bold text-2xl text-green-600">{{ $donation->formatted_amount }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Donation Type:</span>
                    <span class="font-semibold">{{ $donation->donation_type_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method:</span>
                    <span class="font-semibold">{{ $donation->payment_method_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date & Time:</span>
                    <span class="font-semibold">{{ $donation->created_at->format('F d, Y g:i A') }}</span>
                </div>
            </div>

            <!-- Update Status -->
            <div class="mt-6 pt-6 border-t">
                <form action="{{ route('admin.donations.update-status', $donation->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Update Status:</label>
                    <div class="flex gap-2">
                        <select name="status" class="flex-1 px-4 py-2 border rounded-lg">
                            <option value="pending" {{ $donation->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $donation->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $donation->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Donor Information -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Donor Information</h3>
            
            <div class="space-y-3">
                <div>
                    <span class="text-gray-600 text-sm">Name:</span>
                    <p class="font-semibold text-lg">{{ $donation->donor->name }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Email:</span>
                    <p class="font-semibold">{{ $donation->donor->email }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Phone:</span>
                    <p class="font-semibold">{{ $donation->donor->phone }}</p>
                </div>
                <div>
                    <span class="text-gray-600 text-sm">Address:</span>
                    <p class="font-semibold">
                        {{ $donation->donor->street_address }}<br>
                        {{ $donation->donor->city }}, {{ $donation->donor->state }} {{ $donation->donor->zip }}
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <a href="{{ route('admin.donors.show', $donation->donor->id) }}" 
                    class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold">
                    View Donor Profile →
                </a>
            </div>
        </div>

    </div>

    <!-- Check Payment Details -->
    @if($donation->payment_method === 'check')
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Check Payment Details</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-3">
                @if($donation->check_number)
                <div>
                    <span class="text-gray-600 text-sm">Check Number:</span>
                    <p class="font-semibold">{{ $donation->check_number }}</p>
                </div>
                @endif
                
                @if($donation->bank_name)
                <div>
                    <span class="text-gray-600 text-sm">Bank Name:</span>
                    <p class="font-semibold">{{ $donation->bank_name }}</p>
                </div>
                @endif
                
                @if($donation->account_number)
                <div>
                    <span class="text-gray-600 text-sm">Account Number:</span>
                    <p class="font-semibold">{{ $donation->account_number }}</p>
                </div>
                @endif
                
                @if($donation->routing_number)
                <div>
                    <span class="text-gray-600 text-sm">Routing Number:</span>
                    <p class="font-semibold">{{ $donation->routing_number }}</p>
                </div>
                @endif
            </div>
            
            @if($donation->check_photo)
            <div>
                <span class="text-gray-600 text-sm block mb-2">Check Photo:</span>
                <img src="{{ asset('storage/' . $donation->check_photo) }}" 
                    alt="Check Photo" 
                    class="rounded-lg border max-w-full h-auto">
                <a href="{{ asset('storage/' . $donation->check_photo) }}" 
                    target="_blank"
                    class="inline-block mt-2 text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    View Full Size →
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Transaction Details -->
    @if($donation->transaction_id)
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Transaction Details</h3>
        
        <div class="space-y-3">
            <div>
                <span class="text-gray-600 text-sm">Transaction ID:</span>
                <p class="font-semibold font-mono">{{ $donation->transaction_id }}</p>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
