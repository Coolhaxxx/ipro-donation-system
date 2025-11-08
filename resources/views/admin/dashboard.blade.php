@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
        <div class="text-sm text-gray-600">
            {{ now()->format('l, F d, Y') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Donations -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Total Donations</p>
                    <p class="text-3xl font-bold text-gray-800">${{ number_format($stats['total_donations'], 2) }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stats['total_donation_count'] }} donations</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Donors -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Total Donors</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_donors'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">Unique donors</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Donations -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Pending</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_donations'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">Need review</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Completed Donations -->
        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold">Completed</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['completed_donations'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">Processed</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Payment Methods & Donation Types -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Payment Methods -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">By Payment Method</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="font-semibold text-gray-700">💵 Cash</span>
                    <span class="text-lg font-bold text-green-600">${{ number_format($stats['cash_donations'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="font-semibold text-gray-700">📝 Check</span>
                    <span class="text-lg font-bold text-blue-600">${{ number_format($stats['check_donations'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="font-semibold text-gray-700">💳 Online</span>
                    <span class="text-lg font-bold text-purple-600">${{ number_format($stats['online_donations'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Donation Types -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">By Donation Type</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="font-semibold text-gray-700">🕌 Zakat</span>
                    <span class="text-lg font-bold text-green-600">${{ number_format($stats['zakat_donations'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="font-semibold text-gray-700">🤲 Sadaqah</span>
                    <span class="text-lg font-bold text-blue-600">${{ number_format($stats['sadaqah_donations'], 2) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <span class="font-semibold text-gray-700">❤️ General</span>
                    <span class="text-lg font-bold text-purple-600">${{ number_format($stats['general_donations'], 2) }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Donations -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Recent Donations</h3>
            <a href="{{ route('admin.donations') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                View All →
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Donor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Method</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recent_donations as $donation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $donation->donor->name }}</p>
                                <p class="text-sm text-gray-500">{{ $donation->donor->email }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-green-600">{{ $donation->formatted_amount }}</td>
                        <td class="px-4 py-3 text-sm">{{ $donation->donation_type_name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $donation->payment_method_name }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                @if($donation->payment_status === 'completed') bg-green-100 text-green-800
                                @elseif($donation->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($donation->payment_status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $donation->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            No donations yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
