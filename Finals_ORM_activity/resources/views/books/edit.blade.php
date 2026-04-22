<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #1e293b);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            position: relative;
            overflow: hidden;
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
            opacity: 0.05;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            top: -100px;
            left: -50px;
            animation: float 20s infinite ease-in-out;
        }

        .shape-2 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #06b6d4, #f59e0b);
            border-radius: 20% 80% 30% 70% / 70% 20% 80% 30%;
            bottom: -80px;
            right: -30px;
            animation: float 25s infinite ease-in-out reverse;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #ec4899, #d97706);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            top: 50%;
            right: 10%;
            animation: float 22s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-30px) rotate(10deg);
            }
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
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
    </style>
</head>

<body class="animated-bg min-h-screen">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="particles" id="particles-container"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-12 relative z-10">
        <div class="w-full max-w-md">
            <div class="backdrop-blur-2xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-8 relative">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-amber-500/0 via-amber-500/5 to-orange-500/0"></div>
                <div class="mb-8 relative">
                    <h1 class="text-4xl font-bold text-white mb-2">Edit Book</h1>
                    <div class="h-1.5 w-20 bg-gradient-to-r from-amber-400 to-amber-600 rounded-full"></div>
                </div>
                @if($errors->any())
                <div class="mb-6 backdrop-blur-md bg-red-500/20 border border-red-400/50 rounded-xl p-4">
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
                <form action="{{ route('books.update', $books->id) }}" method="POST" class="space-y-6 relative">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="title" class="block text-white text-sm font-semibold mb-2">
                            Title
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ $books->title }}"
                            placeholder="Enter book title"
                            class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition"
                            required>
                    </div>

                    <div>
                        <label for="author" class="block text-white text-sm font-semibold mb-2">
                            Author
                        </label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="{{ $books->author }}"
                            placeholder="Enter author name"
                            class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition"
                            required>
                    </div>

                    <div>
                        <label for="published_date" class="block text-white text-sm font-semibold mb-2">
                            Published Date
                        </label>
                        <input
                            type="date"
                            id="published_date"
                            name="published_date"
                            value="{{ $books->published_date }}"
                            class="w-full px-4 py-3 bg-white/5 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition"
                            required>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const particlesContainer = document.getElementById('particles-container');
        const particleCount = 30;

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