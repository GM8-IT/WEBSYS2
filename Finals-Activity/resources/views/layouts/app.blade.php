<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Student Portal')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center">
  <div class="w-full max-w-3xl mx-auto p-6">
    <header class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-semibold text-primary">Enrollment Student Portal</h1>
      <div>
        @auth
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="px-3 py-1 bg-red-600 text-white rounded">Logout</button>
          </form>
        @endauth
      </div>
    </header>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <main class="bg-white rounded shadow p-6">
      @yield('content')
    </main>
  </div>
</body>
</html>