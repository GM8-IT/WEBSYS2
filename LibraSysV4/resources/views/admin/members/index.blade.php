@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Members</h1>
            <p class="mt-1 text-gray-400">Manage registered library members.</p>
        </div>

        <a href="{{ route('admin.members.create') }}"
           class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
            Add Member
        </a>
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
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search name, email, or student ID..."
                class="flex-1 rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40"
            >

            <button class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Search
            </button>

            <a href="{{ route('admin.members.index') }}"
               class="rounded-xl border border-white/10 px-5 py-3 text-center text-gray-300 hover:bg-white/10">
                Reset
            </a>
        </div>
    </form>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-xl">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Member</th>
                    <th class="px-4 py-3">Student ID</th>
                    <th class="px-4 py-3">Course</th>
                    <th class="px-4 py-3">Year Level</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $member)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-white">
                                {{ $member->name }}
                            </div>
                            <div class="text-gray-400">
                                {{ $member->email }}
                            </div>
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $member->profile->student_id ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $member->profile->course ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $member->profile->year_level ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $member->profile->phone ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.members.edit', $member) }}"
                                   class="rounded-lg border border-white/10 px-3 py-2 text-gray-300 hover:bg-white/10">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button 
                                        type="submit"
                                        onclick="return confirm('Delete this member?')"
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
                            No members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $members->links() }}
    </div>
</div>
@endsection