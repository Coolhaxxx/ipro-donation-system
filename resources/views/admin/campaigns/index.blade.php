@extends('admin.layout')

@section('title', 'Campaigns')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">Campaigns</h2>
        <a href="{{ route('admin.campaigns.create') }}" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Campaign
        </a>
    </div>

    <!-- Campaigns Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($campaigns as $campaign)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden {{ !$campaign->is_active ? 'opacity-75' : '' }}">
            
            <!-- Cover Image -->
            <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-700 relative">
                @if($campaign->cover_image)
                    <img src="{{ asset('storage/' . $campaign->cover_image) }}" 
                        alt="{{ $campaign->name }}" 
                        class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full">
                        <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif

                <!-- Badges -->
                <div class="absolute top-2 right-2 flex gap-2">
                    @if($campaign->is_default)
                    <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">DEFAULT</span>
                    @endif
                    @if($campaign->is_active)
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">ACTIVE</span>
                    @else
                    <span class="bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded">INACTIVE</span>
                    @endif
                </div>
            </div>

            <!-- Campaign Info -->
            <div class="p-6">
                <!-- Logo and Name -->
                <div class="flex items-start mb-4">
                    @if($campaign->logo)
                    <img src="{{ asset('storage/' . $campaign->logo) }}" 
                        alt="{{ $campaign->name }}" 
                        class="w-16 h-16 object-contain mr-4 rounded">
                    @endif
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $campaign->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $campaign->title }}</p>
                    </div>
                </div>

                <!-- Description -->
                @if($campaign->description)
                <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $campaign->description }}</p>
                @endif

                <!-- Stats -->
                <div class="border-t pt-4 mb-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Donations:</span>
                        <span class="font-bold text-green-600">${{ number_format($campaign->total_donations, 2) }}</span>
                    </div>
                    @if($campaign->goal_amount)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Goal:</span>
                        <span class="font-semibold">${{ number_format($campaign->goal_amount, 2) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $campaign->progress_percentage }}%"></div>
                    </div>
                    <div class="text-right text-xs text-gray-500">{{ number_format($campaign->progress_percentage, 1) }}% reached</div>
                    @endif
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Donors:</span>
                        <span class="font-semibold">{{ $campaign->donation_count }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.campaigns.edit', $campaign) }}" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded font-semibold text-sm">
                        Edit
                    </a>
                    
                    <form action="{{ route('admin.campaigns.toggle-active', $campaign) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                            class="w-full {{ $campaign->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded font-semibold text-sm">
                            {{ $campaign->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    @if(!$campaign->is_default)
                    <form action="{{ route('admin.campaigns.set-default', $campaign) }}" method="POST">
                        @csrf
                        <button type="submit" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded font-semibold text-sm"
                            title="Set as Default">
                            ⭐
                        </button>
                    </form>
                    @endif

                    @if($campaign->donations()->count() == 0)
                    <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" 
                        onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold text-sm"
                            title="Delete">
                            🗑️
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-gray-600 text-lg mb-4">No campaigns yet</p>
            <a href="{{ route('admin.campaigns.create') }}" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                Create Your First Campaign
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($campaigns->hasPages())
    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>
    @endif

</div>
@endsection
