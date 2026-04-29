@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Edit Book</h1>
        <p class="mt-1 text-gray-400">Update book information.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-300">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.books.update', $book) }}"
          enctype="multipart/form-data"
          class="space-y-5 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-2 block text-sm text-gray-300">Category</label>
            <select name="category_id" required
                    class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old('category_id', $book->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title', $book->title) }}"
                   required
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Author</label>
            <input type="text"
                   name="author"
                   value="{{ old('author', $book->author) }}"
                   required
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm text-gray-300">Publisher</label>
                <input type="text"
                       name="publisher"
                       value="{{ old('publisher', $book->publisher) }}"
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>

            <div>
                <label class="mb-2 block text-sm text-gray-300">ISBN</label>
                <input type="text"
                       name="isbn"
                       value="{{ old('isbn', $book->isbn) }}"
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Publication Year</label>
            <input type="number"
                   name="publication_year"
                   value="{{ old('publication_year', $book->publication_year) }}"
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Cover Image</label>

            @if($book->cover_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                         alt="{{ $book->title }}"
                         class="h-32 w-24 rounded-xl object-cover">
                </div>
            @endif

            <input type="file"
                   name="cover_image"
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white">
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">{{ old('description', $book->description) }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.books.index') }}"
               class="rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
                Cancel
            </a>

            <button class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Update Book
            </button>
        </div>
    </form>
</div>
@endsection