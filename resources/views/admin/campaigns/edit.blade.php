@extends('admin.layout')

@section('title', 'Edit Campaign')

@section('content')
<div class="space-y-6">
    
    <!-- Back Button -->
    <a href="{{ route('admin.campaigns.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
        ← Back to Campaigns
    </a>

    <!-- Page Header -->
    <h2 class="text-3xl font-bold text-gray-800">Edit Campaign: {{ $campaign->name }}</h2>

    <!-- Form -->
    <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Campaign Name -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Campaign Name *</label>
                    <input type="text" name="name" value="{{ old('name', $campaign->name) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title (Display Title) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Display Title *</label>
                    <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required
                        placeholder="e.g., JAMAICA HURRICANE"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subtitle -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $campaign->subtitle) }}"
                        placeholder="e.g., EMERGENCY RELIEF"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('subtitle') border-red-500 @enderror">
                    @error('subtitle')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Images</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Campaign Logo</label>
                    @if($campaign->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $campaign->logo) }}" alt="Current Logo" class="w-32 h-32 object-contain border rounded">
                            <p class="text-xs text-gray-500 mt-1">Current logo</p>
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('logo') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Max 2MB (PNG, JPG, GIF, SVG) - Leave empty to keep current</p>
                    @error('logo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cover Image</label>
                    @if($campaign->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $campaign->cover_image) }}" alt="Current Cover" class="w-full h-32 object-cover border rounded">
                            <p class="text-xs text-gray-500 mt-1">Current cover image</p>
                        </div>
                    @endif
                    <input type="file" name="cover_image" accept="image/*"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('cover_image') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Max 5MB (PNG, JPG, GIF) - Recommended: 1200x300px - Leave empty to keep current</p>
                    @error('cover_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Campaign Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Campaign Content</h3>
            
            <div class="space-y-6">
                <!-- Goal Text -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Goal/Impact Description</label>
                    <textarea name="goal_text" rows="3"
                        placeholder="Describe the goal of this campaign..."
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('goal_text', $campaign->goal_text) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">This will be shown to donors</p>
                </div>

                <!-- Impact Text -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Impact Statement</label>
                    <textarea name="impact_text" rows="3"
                        placeholder="e.g., Relief provisions include food, medical aid, clean water and shelter supplies"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('impact_text', $campaign->impact_text) }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Shown below donation amounts</p>
                </div>
            </div>
        </div>

        <!-- Campaign Settings -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Campaign Settings</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goal Amount -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Goal Amount (Optional)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-600">$</span>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount', $campaign->goal_amount) }}" step="0.01" min="0"
                            class="w-full pl-8 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Leave empty if no specific goal</p>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date (Optional)</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $campaign->start_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">End Date (Optional)</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $campaign->end_date?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status Toggles -->
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $campaign->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-2 font-semibold text-gray-700">Active (visible to donors)</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="is_default" value="1" {{ old('is_default', $campaign->is_default) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded">
                        <span class="ml-2 font-semibold text-gray-700">Set as Default Campaign</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-4">
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg">
                Update Campaign
            </button>
            <a href="{{ route('admin.campaigns.index') }}" 
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg">
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection
