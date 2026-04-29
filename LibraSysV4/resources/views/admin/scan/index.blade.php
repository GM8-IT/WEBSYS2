@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Scan Book</h1>
        <p class="mt-1 text-gray-400">Enter or scan a book barcode.</p>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.scan.lookup') }}"
          class="space-y-5 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        @csrf

        <div>
            <label class="mb-2 block text-sm text-gray-300">Barcode / Accession Number</label>
            <input type="text"
                   name="barcode"
                   required
                   autofocus
                   placeholder="Example: LIB-ABC123 or LS-000001"
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <button class="w-full rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
            Search Book Copy
        </button>
    </form>
</div>
@endsection