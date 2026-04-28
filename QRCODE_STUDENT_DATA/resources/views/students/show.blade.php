@extends('layouts.app')

@section('content')
<style>
    .show-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(300px, 0.8fr);
        gap: 18px;
        align-items: stretch;
    }

    .detail-card {
        padding: 28px;
    }

    .student-hero-name {
        margin: 0 0 16px;
        font-size: clamp(2rem, 5vw, 4rem);
        line-height: 0.95;
        font-weight: 900;
        letter-spacing: -0.07em;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 24px;
    }

    .mini-card {
        padding: 18px;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.14);
        background: rgba(255,255,255,0.06);
        transition: 0.22s ease;
    }

    .mini-card:hover {
        transform: translateY(-4px);
        background: rgba(255,255,255,0.1);
    }

    .mini-card span {
        display: block;
        margin-bottom: 8px;
        color: rgba(255,255,255,0.42);
        font-size: 0.72rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .mini-card strong {
        color: #ffffff;
        font-size: 1.05rem;
        word-break: break-word;
    }

    .qr-panel {
        padding: 28px;
        text-align: center;
    }

    .qr-large {
        display: flex;
        align-items: center;
        justify-content: center;
        width: min(100%, 270px);
        aspect-ratio: 1 / 1;
        margin: 24px auto;
        padding: 24px;
        border-radius: 30px;
        background: #ffffff;
        box-shadow: 0 28px 60px rgba(0,0,0,0.45);
        animation: floatSoft 4s ease-in-out infinite;
    }

    .qr-large svg,
    .qr-large img {
        width: 100%;
        height: auto;
    }

    .qr-note {
        color: rgba(255,255,255,0.6);
        line-height: 1.7;
    }

    @media (max-width: 992px) {
        .show-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .details-grid {
            grid-template-columns: 1fr;
        }

        .detail-card,
        .qr-panel {
            padding: 20px;
        }
    }
</style>

<div class="page-header">
    <div class="eyebrow">Student Profile</div>
    <h1 class="page-title">QR Student Details</h1>
    <p class="page-description">
        View the complete student record and scan the generated QR code containing all student information.
    </p>
</div>

<div class="show-grid">
    <section class="glass-panel detail-card">
        <h2 class="student-hero-name">
            {{ $student->first_name }} {{ $student->last_name }}
        </h2>

        <p class="page-description">
            Student record for <strong>{{ $student->student_id }}</strong>. This profile is connected to a generated QR code.
        </p>

        <div class="details-grid">
            <div class="mini-card">
                <span>Database ID</span>
                <strong>#{{ $student->id }}</strong>
            </div>

            <div class="mini-card">
                <span>Student ID</span>
                <strong>{{ $student->student_id }}</strong>
            </div>

            <div class="mini-card">
                <span>Course</span>
                <strong>{{ $student->course }}</strong>
            </div>

            <div class="mini-card">
                <span>Year Level</span>
                <strong>{{ $student->year_level }}</strong>
            </div>

            <div class="mini-card">
                <span>Section</span>
                <strong>{{ $student->section }}</strong>
            </div>

            <div class="mini-card">
                <span>Email</span>
                <strong>{{ $student->email ?: 'No email' }}</strong>
            </div>

            <div class="mini-card">
                <span>Contact Number</span>
                <strong>{{ $student->contact_number ?: 'No contact number' }}</strong>
            </div>

            <div class="mini-card">
                <span>Address</span>
                <strong>{{ $student->address ?: 'No address' }}</strong>
            </div>
        </div>

        <div class="d-flex gap-2 flex-wrap mt-4">
            <a href="{{ route('students.edit', $student->id) }}" class="modern-btn primary">
                Edit Student
            </a>

            <a href="{{ route('students.index') }}" class="modern-btn">
                Back to Dashboard
            </a>
        </div>
    </section>

    <aside class="glass-panel qr-panel">
        <div class="eyebrow">Generated QR</div>

        <h2 class="brand-title fs-3">
            Scan Student Data
        </h2>

        <p class="qr-note">
            This QR code contains the student's full saved information in structured format.
        </p>

        <div class="qr-large">
            {!! $qr !!}
        </div>

        <p class="qr-note">
            Use any QR scanner to view the encoded student record.
        </p>
    </aside>
</div>
@endsection