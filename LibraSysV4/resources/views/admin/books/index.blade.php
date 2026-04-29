@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Books</h1>
            <p class="mt-1 text-gray-400">Manage library books and copies.</p>
        </div>

        <a href="{{ route('admin.books.create') }}"
           class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
            Add Book
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="grid gap-4 rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl md:grid-cols-3">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Search title, author, ISBN..."
            class="rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40"
        >

        <select 
            name="category_id"
            class="rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40"
        >
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button class="rounded-xl bg-white px-4 py-3 font-semibold text-black hover:bg-gray-200">
            Filter
        </button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-xl">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Book</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Copies</th>
                    <th class="px-4 py-3">Available</th>
                    <th class="px-4 py-3">Borrowed</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-white">{{ $book->title }}</div>
                            <div class="text-gray-400">{{ $book->author }}</div>
                        </td>
                        <td class="px-4 py-4 text-gray-300">
                            {{ $book->category->name }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $book->copies_count }}
                        </td>
                        <td class="px-4 py-4 text-green-300">
                            {{ $book->available_copies_count }}
                        </td>
                        <td class="px-4 py-4 text-yellow-300">
                            {{ $book->borrowed_copies_count }}
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.books.show', $book) }}"
                                   class="rounded-lg border border-white/10 px-3 py-2 text-gray-300 hover:bg-white/10">
                                    View
                                </a>

                                <a href="{{ route('admin.books.edit', $book) }}"
                                   class="rounded-lg border border-white/10 px-3 py-2 text-gray-300 hover:bg-white/10">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        onclick="return confirm('Delete this book?')"
                                        class="rounded-lg border border-red-500/30 px-3 py-2 text-red-300 hover:bg-red-500/10">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            No books found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $books->links() }}
</div>
@endsection