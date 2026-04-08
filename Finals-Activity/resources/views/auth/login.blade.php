@extends('layouts.app')

@section('title','Login')

@section('content')
<div class="max-w-md mx-auto">
  <h2 class="text-xl font-semibold mb-4">Sign in</h2>
  <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-sm font-medium">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-medium">Password</label>
      <input type="password" name="password" class="mt-1 block w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex items-center justify-between">
      <div>
        <label class="inline-flex items-center">
          <input type="checkbox" name="remember" class="form-checkbox">
          <span class="ml-2 text-sm">Remember me</span>
        </label>
      </div>
      <div>
        <a href="#" class="text-sm text-blue-600">Forgot password?</a>
      </div>
    </div>
    <div>
      <button class="w-full py-2 bg-blue-600 text-white rounded">Login</button>
    </div>
  </form>

  <div class="mt-4 text-sm">
    Don't have an account? <a href="{{ route('register') }}" class="text-blue-600">Register</a>
  </div>
</div>
@endsection