@extends('admin.layout')

@section('title', 'Profile')

@section('content')
<div class="space-y-6">
    
    <h2 class="text-3xl font-bold text-gray-800">Admin Profile</h2>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Profile Information -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Profile Information</h3>
            
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                            Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Change Password</h3>
            
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                
                <!-- Hidden fields to preserve name and email -->
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                
                <div class="space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                        <input type="password" name="new_password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg">
                            Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <!-- Account Info -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Account Information</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-gray-600 text-sm">Account Created:</span>
                <p class="font-semibold">{{ $user->created_at->format('F d, Y') }}</p>
            </div>
            <div>
                <span class="text-gray-600 text-sm">Last Login:</span>
                <p class="font-semibold">{{ $user->updated_at->format('F d, Y g:i A') }}</p>
            </div>
            <div>
                <span class="text-gray-600 text-sm">User ID:</span>
                <p class="font-semibold">#{{ $user->id }}</p>
            </div>
            <div>
                <span class="text-gray-600 text-sm">Role:</span>
                <p class="font-semibold">Administrator</p>
            </div>
        </div>
    </div>

</div>
@endsection
