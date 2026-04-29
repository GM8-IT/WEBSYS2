@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Categories</h1>
            <p class="mt-1 text-gray-400">Manage book categories.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
            Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-xl">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Category Name</th>
                    <th class="px-4 py-3">Books Count</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4 font-semibold text-white">
                            {{ $category->name }}
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $category->books_count }}
                        </td>

                        <td class="px-4 py-4 text-gray-400">
                            {{ $category->created_at->format('M d, Y') }}
                        </td>

                        <td class="px-4 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="rounded-lg border border-white/10 px-3 py-2 text-gray-300 hover:bg-white/10">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('Delete this category?')"
                                            class="rounded-lg border border-red-500/30 px-3 py-2 text-red-300 hover:bg-red-500/10">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links() }}
</div>
@endsection