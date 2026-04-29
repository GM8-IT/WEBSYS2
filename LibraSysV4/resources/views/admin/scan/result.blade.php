@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Scan Result</h1>
        <p class="mt-1 text-gray-400">Book copy information.</p>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <div class="flex flex-col gap-6 md:flex-row md:items-center">
            <div class="rounded-xl bg-white p-3">
                {!! QrCode::size(130)->generate($copy->barcode) !!}
            </div>

            <div class="flex-1">
                <h2 class="text-2xl font-bold">{{ $copy->book->title }}</h2>
                <p class="mt-1 text-gray-400">{{ $copy->book->author }}</p>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gray-400">Accession Number</p>
                        <p class="font-semibold">{{ $copy->accession_number }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Barcode</p>
                        <p class="font-semibold">{{ $copy->barcode }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-400">Status</p>
                        <p class="font-semibold capitalize">{{ $copy->status }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($activeBorrowing)
        <div class="rounded-3xl border border-yellow-500/30 bg-yellow-500/10 p-6">
            <h2 class="text-xl font-bold text-yellow-300">Currently Borrowed</h2>

            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-sm text-gray-400">Borrower</p>
                    <p class="font-semibold">{{ $activeBorrowing->user->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-400">Due Date</p>
                    <p class="font-semibold">{{ $activeBorrowing->due_at->format('M d, Y') }}</p>
                </div>
            </div>

            <form method="POST"
                  action="{{ route('admin.borrowings.return', $activeBorrowing) }}"
                  class="mt-5">
                @csrf
                @method('PATCH')

                <button onclick="return confirm('Mark this book as returned?')"
                        class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                    Return Book
                </button>
            </form>
        </div>
    @else
        <div class="rounded-3xl border border-green-500/30 bg-green-500/10 p-6">
            <h2 class="text-xl font-bold text-green-300">This copy is not actively borrowed.</h2>

            @if($copy->status === 'available')
                <a href="{{ route('admin.borrowings.create') }}"
                   class="mt-5 inline-block rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                    Borrow This Book
                </a>
            @endif
        </div>
    @endif

    <a href="{{ route('admin.scan.index') }}"
       class="inline-block rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
        Scan Another
    </a>
</div>
@endsection