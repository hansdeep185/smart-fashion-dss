<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Fashion DSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Welcome Back!</h1>
            <p class="text-gray-500 text-sm">Smart Fashion Decision System</p>
        </div>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="admin@admin.com" required autofocus>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="********" required>
            </div>

            @error('email')
                <p class="text-red-500 text-xs italic mb-4">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full bg-pink-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-pink-700 transition duration-300">
                Login Masuk
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; 2024 Smart Fashion Project
        </div>
    </div>

</body>
</html>