<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart Fashion DSS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-gray-900 text-white flex flex-col shadow-lg">
            <div class="h-16 flex items-center justify-center bg-gray-800 border-b border-gray-700">
                <h1 class="text-xl font-bold tracking-wider text-pink-500">
                    <i class="fa-solid fa-shirt mr-2"></i>Smart Fashion
                </h1>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2">
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-pink-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fa-solid fa-gauge w-6"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu DSS</p>
                </div>

                <a href="{{ route('evaluation.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('evaluation.*') ? 'bg-pink-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fa-solid fa-pen-to-square w-6"></i>
                    <span class="font-medium">Input Penilaian</span>
                </a>

                <a href="{{ route('dss.result') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dss.result') ? 'bg-pink-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fa-solid fa-calculator w-6"></i>
                    <span class="font-medium">Hasil Perhitungan</span>
                </a>

            </nav>

            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-xs font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm transition">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm p-4 flex justify-between items-center lg:hidden">
                <span class="font-bold">Smart Fashion DSS</span>
                <button class="text-gray-600"><i class="fa-solid fa-bars"></i></button>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>