<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">

<div class="flex">
    <aside class="w-64 h-screen bg-gray-900 text-gray-200 fixed shadow-xl z-50">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">🛒 Sari-Sari</div>
        <nav class="p-4 text-sm space-y-1">
            <a href="/" class="flex items-center p-3 rounded hover:bg-gray-800">Dashboard</a>
            <a href="/products" class="flex items-center p-3 rounded hover:bg-gray-800">Products</a>
            <a href="/customers" class="flex items-center p-3 rounded hover:bg-gray-800">Customers</a>
            <a href="/utangs" class="flex items-center p-3 rounded hover:bg-gray-800">Utangs</a>
            <a href="/suggestions" class="flex items-center p-3 rounded hover:bg-gray-800">Purchase Suggestions</a>
        </nav>
    </aside>

    <main class="ml-64 w-full min-h-screen">
        <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-40">
    <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
    
    <div class="flex items-center space-x-5">
        <div class="flex items-center space-x-3">
            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-bold text-red-600 hover:text-red-800 transition">
                    Log Out
                </button>
            </form>
            
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>
</header>

        <div class="p-8">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>