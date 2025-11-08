@extends('admin.layout')

@section('title', 'All Donations')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">All Donations</h2>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.donations') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            
            <!-- Search -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Search Donor</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Name or email..."
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <!-- Payment Method Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Method</label>
                <select name="method" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Methods</option>
                    <option value="cash" {{ request('method') === 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="check" {{ request('method') === 'check' ? 'selected' : '' }}>Check</option>
                    <option value="online" {{ request('method') === 'online' ? 'selected' : '' }}>Online</option>
                </select>
            </div>

            <!-- Donation Type Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Donation Type</label>
                <select name="type" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="zakat" {{ request('type') === 'zakat' ? 'selected' : '' }}>Zakat</option>
                    <option value="sadaqah" {{ request('type') === 'sadaqah' ? 'selected' : '' }}>Sadaqah</option>
                    <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                    Apply Filters
                </button>
                <a href="{{ route('admin.donations') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Donations Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Donor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Method</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donations as $donation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold">#{{ str_pad($donation->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $donation->donor->name }}</p>
                                <p class="text-sm text-gray-500">{{ $donation->donor->email }}</p>
                                <p class="text-sm text-gray-500">{{ $donation->donor->phone }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-bold text-green-600">{{ $donation->formatted_amount }}</td>
                        <td class="px-4 py-3 text-sm">{{ $donation->donation_type_name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $donation->payment_method_name }}</td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.donations.update-status', $donation->id) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs font-semibold rounded-full px-3 py-1 border-0
                                    @if($donation->payment_status === 'completed') bg-green-100 text-green-800
                                    @elseif($donation->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    <option value="pending" {{ $donation->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $donation->payment_status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="failed" {{ $donation->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $donation->created_at->format('M d, Y') }}<br>
                            <span class="text-xs text-gray-400">{{ $donation->created_at->format('g:i A') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.donations.show', $donation->id) }}" 
                                class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                View Details →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            No donations found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($donations->hasPages())
        <div class="px-4 py-4 border-t">
            {{ $donations->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
