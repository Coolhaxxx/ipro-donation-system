<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - iPro</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-bold">iPro Admin</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('admin.dashboard') }}" 
                            class="px-3 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.donations') }}" 
                            class="px-3 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('admin.donations*') ? 'bg-blue-800' : '' }}">
                            Donations
                        </a>
                        <a href="{{ route('admin.donors') }}" 
                            class="px-3 py-2 rounded hover:bg-blue-800 {{ request()->routeIs('admin.donors*') ? 'bg-blue-800' : '' }}">
                            Donors
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('donation.form') }}" target="_blank" class="text-sm hover:text-gray-300">
                        View Donation Form →
                    </a>
                    <span class="text-sm">{{ auth()->user()->name ?? auth()->user()->email }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
