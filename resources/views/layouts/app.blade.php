<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Inventory</title>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flowbite (CDN) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-gray-900 text-gray-200 fixed shadow-xl">
        <div class="p-6 text-2xl font-bold border-b border-gray-700">
            🛒 Sari-Sari
        </div>

        <nav class="p-4 text-sm space-y-1">

            <a href="/" class="flex items-center p-3 rounded hover:bg-gray-800">
                <span class="ml-2">Dashboard</span>
            </a>

            <a href="/products" class="flex items-center p-3 rounded hover:bg-gray-800">
                <span class="ml-2">Products</span>
            </a>

            <a href="/customers" class="flex items-center p-3 rounded hover:bg-gray-800">
                <span class="ml-2">Customers</span>
            </a>

            <a href="/utangs" class="flex items-center p-3 rounded hover:bg-gray-800">
                <span class="ml-2">Utangs</span>
            </a>

            <a href="/suggestions" class="flex items-center p-3 rounded hover:bg-gray-800">
                <span class="ml-2">Purchase Suggestions</span>
            </a>

        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="ml-64 w-full">

        <!-- TOP NAVBAR -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">@yield('title')</h1>

            <div class="flex items-center space-x-3">
                <input type="text" placeholder="Search..."
                       class="border px-3 py-2 rounded-lg text-sm">
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
            </div>
        </header>

        <div class="p-8">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>
