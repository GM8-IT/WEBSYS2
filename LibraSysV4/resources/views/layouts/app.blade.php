<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraSys</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-black text-white">
    <div class="flex min-h-screen">
        <aside class="hidden w-72 border-r border-white/10 bg-white/5 p-6 backdrop-blur-xl lg:block">
            <h1 class="text-2xl font-bold">LibraSys</h1>
            <p class="mt-1 text-sm capitalize text-gray-400">{{ auth()->user()->role }}</p>

            <nav class="mt-8 space-y-2">
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Dashboard
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Categories
                </a>

                <a href="{{ route('admin.books.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Books
                </a>

                <a href="{{ route('admin.members.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Members
                </a>

                <a href="{{ route('admin.borrowings.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Borrowings
                </a>
                <a href="{{ route('admin.reservations.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Reservations
                </a>
                <a href="{{ route('admin.scan.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Scan
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Reports
                </a>
                @else
                <a href="{{ route('member.dashboard') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Dashboard
                </a>

                <a href="{{ route('member.books.index') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Books
                </a>

                <a href="{{ route('member.history') }}"
                    class="block rounded-xl px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                    Borrowing History
                </a>
                @endif
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button class="w-full rounded-xl border border-white/10 px-4 py-3 text-left text-gray-300 hover:bg-white/10 hover:text-white">
                    Logout
                </button>
            </form>
        </aside>

        <main class="flex-1 p-6 lg:p-10">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>

</html>