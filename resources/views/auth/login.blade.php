<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sari-Sari Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 flex items-center justify-center">
                🛒 <span class="ml-2">Sari-Sari</span>
            </h1>
            <p class="text-gray-500 mt-2 font-medium tracking-wide">Admin Portal</p>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 bg-white shadow-xl rounded-2xl border border-gray-100">
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-widest">Admin Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-200 transition outline-none"
                           placeholder="admin@sarisari.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-widest">Password</label>
                    <input id="password" type="password" name="password" required 
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-slate-900 focus:ring-2 focus:ring-slate-200 transition outline-none"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center mb-8">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-slate-900 focus:ring-slate-900">
                        <span class="ml-2 text-sm text-gray-600 font-medium">Keep me logged in</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 transition-all shadow-lg active:scale-95 uppercase tracking-widest text-sm">
                    Enter Dashboard
                </button>
            </form>
        </div>

        <p class="mt-8 text-xs text-gray-400 font-medium">© 2025 Sari-Sari Inventory • Secure Admin Access</p>
    </div>
</body>
</html>