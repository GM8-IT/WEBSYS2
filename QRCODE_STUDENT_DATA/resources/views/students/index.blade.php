@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: flex-end;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .toolbar {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-form {
        display: flex;
        gap: 10px;
        min-width: min(100%, 520px);
    }

    .table-shell {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table th {
        padding: 18px 16px;
        color: rgba(255,255,255,0.45);
        font-size: 0.73rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-bottom: 1px solid rgba(255,255,255,0.13);
        background: rgba(255,255,255,0.04);
        white-space: nowrap;
    }

    .modern-table td {
        padding: 18px 16px;
        color: rgba(255,255,255,0.72);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        vertical-align: middle;
    }

    .modern-table tbody tr {
        animation: riseUp 0.5s ease both;
        transition: 0.22s ease;
    }

    .modern-table tbody tr:hover {
        background: rgba(255,255,255,0.06);
    }

    .qr-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 88px;
        height: 88px;
        padding: 10px;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 16px 34px rgba(0,0,0,0.35);
        animation: floatSoft 4s ease-in-out infinite;
    }

    .qr-card svg,
    .qr-card img {
        width: 68px;
        height: auto;
        display: block;
    }

    .student-name {
        color: #ffffff;
        font-weight: 900;
        letter-spacing: -0.02em;
    }

    .student-sub {
        margin-top: 4px;
        color: rgba(255,255,255,0.42);
        font-size: 0.85rem;
    }

    .pill {
        display: inline-flex;
        padding: 7px 11px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,0.14);
        background: rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.82);
        font-weight: 800;
        font-size: 0.82rem;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .empty-state {
        padding: 52px 20px !important;
        text-align: center;
    }

    .empty-state h3 {
        color: #ffffff;
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .empty-state p {
        color: rgba(255,255,255,0.55);
    }

    @media (max-width: 768px) {
        .search-form {
            width: 100%;
            flex-direction: column;
        }

        .toolbar {
            width: 100%;
        }

        .modern-btn {
            width: 100%;
        }
    }
</style>

<div class="dashboard-header">
    <div class="page-header mb-0">
        <div class="eyebrow">Activity 3</div>
        <h1 class="page-title">Student Records</h1>
        <p class="page-description">
            Manage student information, generate QR codes, and search records in a modern animated dashboard.
        </p>
    </div>

    <div class="toolbar">
        <a href="{{ route('students.create') }}" class="modern-btn primary">
            + Add Student
        </a>
    </div>
</div>

<div class="glass-panel mb-4 p-3">
    <form action="{{ route('students.index') }}" method="GET" class="search-form">
        <input
            type="text"
            name="search"
            class="modern-input"
            placeholder="Search by student ID, name, course, section, or email..."
            value="{{ $search }}"
        >

        <button type="submit" class="modern-btn primary">
            Search
        </button>

        @if($search)
            <a href="{{ route('students.index') }}" class="modern-btn">
                Clear
            </a>
        @endif
    </form>
</div>

<div class="glass-panel table-shell">
    <table class="modern-table">
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Student</th>
                <th>Course</th>
                <th>Year</th>
                <th>Section</th>
                <th>Email</th>
                <th width="260">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>
                        <div class="qr-card">
                            {!! $student->qr !!}
                        </div>
                    </td>

                    <td>
                        <div class="student-name">
                            {{ $student->first_name }} {{ $student->last_name }}
                        </div>
                        <div class="student-sub">
                            ID: {{ $student->student_id }}
                        </div>
                    </td>

                    <td>
                        <span class="pill">{{ $student->course }}</span>
                    </td>

                    <td>{{ $student->year_level }}</td>

                    <td>{{ $student->section }}</td>

                    <td>{{ $student->email ?: 'No email' }}</td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('students.show', $student->id) }}" class="modern-btn primary">
                                View
                            </a>

                            <a href="{{ route('students.edit', $student->id) }}" class="modern-btn">
                                Edit
                            </a>

                            <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="modern-btn danger"
                                    onclick="return confirm('Are you sure you want to delete this student?')"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <h3>No students found</h3>
                        <p>Create your first student record to generate a QR code.</p>
                        <a href="{{ route('students.create') }}" class="modern-btn primary">
                            Add Student
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection