<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraSys Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-white">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-white/10 p-8 shadow-2xl backdrop-blur-xl">
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold">LibraSys</h1>
                <p class="mt-2 text-gray-400">Library Management System</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm text-gray-300">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40"
                    >
                </div>

                <div>
                    <label class="mb-2 block text-sm text-gray-300">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        required
                        class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40"
                    >
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded">
                    <label for="remember" class="text-sm text-gray-400">Remember me</label>
                </div>

                <button 
                    type="submit"
                    class="w-full rounded-xl bg-white px-4 py-3 font-semibold text-black transition hover:bg-gray-200"
                >
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>