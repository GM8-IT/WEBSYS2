@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">{{ $book->title }}</h1>
            <p class="mt-1 text-gray-400">Book details and copy records.</p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.books.edit', $book) }}"
                class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Edit Book
            </a>

            <a href="{{ route('admin.books.index') }}"
                class="rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
                Back
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
            @if($book->cover_image)
            <img src="{{ asset('storage/' . $book->cover_image) }}"
                alt="{{ $book->title }}"
                class="mb-5 h-80 w-full rounded-2xl object-cover">
            @else
            <div class="mb-5 flex h-80 items-center justify-center rounded-2xl bg-black/40 text-gray-500">
                No Cover
            </div>
            @endif

            <h2 class="text-xl font-bold">{{ $book->title }}</h2>
            <p class="mt-1 text-gray-400">{{ $book->author }}</p>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl lg:col-span-2">
            <h2 class="mb-5 text-xl font-bold">Book Information</h2>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-400">Category</p>
                    <p class="font-semibold">{{ $book->category->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">ISBN</p>
                    <p class="font-semibold">{{ $book->isbn ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Publisher</p>
                    <p class="font-semibold">{{ $book->publisher ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Publication Year</p>
                    <p class="font-semibold">{{ $book->publication_year ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Total Copies</p>
                    <p class="font-semibold">{{ $book->copies->count() }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Available Copies</p>
                    <p class="font-semibold text-green-300">
                        {{ $book->copies->where('status', 'available')->count() }}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-400">Description</p>
                <p class="mt-2 leading-7 text-gray-300">
                    {{ $book->description ?? 'No description available.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <h2 class="mb-5 text-xl font-bold">Book Copies</h2>

        <div class="overflow-hidden rounded-2xl border border-white/10">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-gray-400">
                    <tr>
                        <th class="px-4 py-3">QR</th>
                        <th class="px-4 py-3">Accession Number</th>
                        <th class="px-4 py-3">Barcode</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Created</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($book->copies as $copy)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            <div class="inline-block rounded-xl bg-white p-2">
                                {!! QrCode::size(80)->generate($copy->barcode) !!}
                            </div>
                        </td>

                        <td class="px-4 py-4 font-semibold">
                            {{ $copy->accession_number }}
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $copy->barcode }}
                        </td>
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4 font-semibold">{{ $copy->accession_number }}</td>
                        <td class="px-4 py-4 text-gray-300">{{ $copy->barcode }}</td>
                        <td class="px-4 py-4">
                            <span class="rounded-full border border-white/10 px-3 py-1 text-xs capitalize
                                    @if($copy->status === 'available') text-green-300
                                    @elseif($copy->status === 'borrowed') text-yellow-300
                                    @elseif($copy->status === 'reserved') text-blue-300
                                    @else text-red-300
                                    @endif">
                                {{ $copy->status }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-gray-400">
                            {{ $copy->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            No copies found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection