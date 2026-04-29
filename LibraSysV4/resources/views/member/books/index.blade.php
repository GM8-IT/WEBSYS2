@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Available Books</h1>
        <p class="mt-1 text-gray-400">Browse the library collection.</p>
    </div>
    @if(session('success'))
    <div class="rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-300">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-300">
        {{ session('error') }}
    </div>
    @endif

    <form method="GET" class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl">
        <div class="flex flex-col gap-3 sm:flex-row">
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title or author..."
                class="flex-1 rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">

            <button class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Search
            </button>

            <a href="{{ route('member.books.index') }}"
                class="rounded-xl border border-white/10 px-5 py-3 text-center text-gray-300 hover:bg-white/10">
                Reset
            </a>
        </div>
    </form>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($books as $book)
        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/10 backdrop-blur-xl">
            @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}"
                alt="{{ $book->title }}"
                class="h-56 w-full object-cover">
            @else
            <div class="flex h-56 items-center justify-center bg-black/40 text-gray-500">
                No Cover
            </div>
            @endif

            <div class="space-y-4 p-5">
                <div>
                    <h2 class="text-xl font-bold">{{ $book->title }}</h2>
                    <p class="mt-1 text-gray-400">{{ $book->author }}</p>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-400">{{ $book->category->name }}</span>

                    <span class="rounded-full border border-white/10 px-3 py-1
                            {{ $book->available_copies_count > 0 ? 'text-green-300' : 'text-red-300' }}">
                        {{ $book->available_copies_count }} available
                    </span>
                </div>

                <p class="line-clamp-3 text-sm leading-6 text-gray-400">
                    {{ $book->description ?? 'No description available.' }}
                </p>
                @if($book->available_copies_count <= 0)
                    <form method="POST" action="{{ route('member.books.reserve', $book) }}">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-xl border border-white/10 px-4 py-3 text-gray-300 hover:bg-white/10 hover:text-white">
                        Reserve Book
                    </button>
                    </form>
                    @endif
            </div>
        </div>
        @empty
        <div class="rounded-3xl border border-white/10 bg-white/10 p-8 text-center text-gray-400 backdrop-blur-xl sm:col-span-2 lg:col-span-3">
            No books found.
        </div>
        @endforelse
    </div>

    {{ $books->links() }}
</div>
@endsection