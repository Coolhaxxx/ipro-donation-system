<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - iPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-700 min-h-screen flex items-center justify-center">
    
    <div class="bg-white rounded-lg shadow-2xl p-8 w-full max-w-md">
        
        <!-- Logo/Title -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-900">iPro Admin</h1>
            <p class="text-gray-600 mt-2">Sign in to your account</p>
        </div>

        <!-- Messages -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address
                </label>
                <input type="email" id="email" name="email" required
                    value="{{ old('email') }}"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="admin@example.com">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    Password
                </label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="••••••••">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 rounded-lg transition duration-200 transform hover:scale-105">
                Sign In
            </button>
        </form>

        <!-- Back to Site Link -->
        <div class="text-center mt-6">
            <a href="{{ route('donation.form') }}" class="text-sm text-blue-600 hover:text-blue-800">
                ← Back to Donation Form
            </a>
        </div>

    </div>

</body>
</html>
