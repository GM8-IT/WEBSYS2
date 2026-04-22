<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Library</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #1e293b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .shape {
            position: absolute;
            opacity: 0.04;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            top: -150px;
            left: -100px;
            animation: float 25s infinite ease-in-out;
        }

        .shape-2 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #06b6d4, #3b82f6);
            border-radius: 20% 80% 30% 70% / 70% 20% 80% 30%;
            bottom: -100px;
            right: -50px;
            animation: float 30s infinite ease-in-out reverse;
        }

        .shape-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #ec4899, #f43f5e);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            top: 50%;
            right: 5%;
            animation: float 27s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-40px) rotate(15deg);
            }
        }

        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            top: 0;
            left: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: particle-float linear infinite;
        }

        @keyframes particle-float {
            0% {
                opacity: 0;
                transform: translateY(100vh) translateX(0);
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(-100vh) translateX(100px);
            }
        }

        body {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="animated-bg">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="particles" id="particles-container"></div>

        <div class="relative z-10">
            <nav class="backdrop-blur-2xl bg-white/5 border-b border-white/10 sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                        </svg>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Books Library</h1>
                    </div>
                    <a
                        href="{{ route('books.create') }}"
                        class="px-6 py-2.5 bg-gradient-to-r from-black-500 to-black-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        + Add New Book
                    </a>
                </div>
            </nav>

            <div class="max-w-7xl mx-auto px-6 py-12">
                @if($errors->any())
                <div class="mb-8 backdrop-blur-md bg-red-500/20 border border-red-400/50 rounded-xl p-6">
                    <h3 class="text-red-200 font-semibold mb-3">Errors:</h3>
                    <ul class="space-y-2">
                        @foreach($errors->all() as $error)
                        <li class="text-red-200 text-sm flex items-start">
                            <span class="mr-2">•</span>
                            <span>{{ $error }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($books->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($books as $book)
                    <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:scale-105 group">
                        <div class="h-1.5 bg-gradient-to-r from-blue-500 to-purple-500"></div>
                        <div class="relative p-6">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            <div class="relative z-10">
                                <h2 class="text-xl font-bold text-white mb-1 line-clamp-2 group-hover:text-blue-300 transition">
                                    {{ $book->title }}
                                </h2>
                                <p class="text-blue-200/80 text-sm mb-4">by {{ $book->author }}</p>
                                <div class="flex items-center text-white/60 text-xs mb-6 bg-white/5 rounded-lg px-3 py-2 w-fit">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 011 1v1h1a1 1 0 110 2H7v1a1 1 0 11-2 0v-1H4a1 1 0 110-2h1V8a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $book->published_date }}
                                </div>
                                <div class="flex gap-3 pt-4 border-t border-white/10">
                                    <a
                                        href="{{ route('books.edit', $book->id) }}"
                                        class="flex-1 py-2.5 px-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-semibold rounded-lg transition duration-300 text-center transform hover:scale-105">
                                        Edit
                                    </a>
                                    <form
                                        action="{{ route('books.destroy', $book->id) }}"
                                        method="POST"
                                        class="flex-1"
                                        onsubmit="return confirm('Are you sure you want to delete this book?');">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="w-full py-2.5 px-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-semibold rounded-lg transition duration-300 transform hover:scale-105">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-16 text-center">
                    <svg class="w-20 h-20 text-white/40 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-white mb-2">No Books Found</h3>
                    <p class="text-white/60 mb-8 text-lg">Start building your library by adding your first book</p>
                    <a
                        href="{{ route('books.create') }}"
                        class="inline-block px-8 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        Add Your First Book
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const particlesContainer = document.getElementById('particles-container');
        const particleCount = 40;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
            particle.style.animationDelay = Math.random() * 5 + 's';
            particlesContainer.appendChild(particle);
        }
    </script>
</body>

</html>