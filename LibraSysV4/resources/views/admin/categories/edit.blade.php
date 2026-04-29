@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Edit Category</h1>
        <p class="mt-1 text-gray-400">Update category information.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-300">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.categories.update', $category) }}"
          class="space-y-5 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-2 block text-sm text-gray-300">Category Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $category->name) }}"
                   required
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
                Cancel
            </a>

            <button class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection