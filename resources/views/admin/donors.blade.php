@extends('admin.layout')

@section('title', 'All Donors')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">All Donors</h2>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('admin.donors') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search by name, email, or phone..."
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                Search
            </button>
            @if(request('search'))
            <a href="{{ route('admin.donors') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold">
                Clear
            </a>
            @endif
        </form>
    </div>

    <!-- Donors Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Address</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total Donations</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Registered</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($donors as $donor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-semibold">#{{ str_pad($donor->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $donor->name }}</td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-600">{{ $donor->email }}</p>
                            <p class="text-sm text-gray-600">{{ $donor->phone }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $donor->city }}, {{ $donor->state }} {{ $donor->zip }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-bold text-green-600">${{ number_format($donor->total_donations, 2) }}</span>
                            <p class="text-xs text-gray-500">{{ $donor->donations_count }} donation(s)</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $donor->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.donors.show', $donor->id) }}" 
                                class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                View Details →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            No donors found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($donors->hasPages())
        <div class="px-4 py-4 border-t">
            {{ $donors->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
