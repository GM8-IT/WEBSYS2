<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::with('profile')
            ->where('role', 'member')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Student ID',
            'Course',
            'Year Level',
            'Phone',
            'Address',
        ];
    }

    public function map($member): array
    {
        return [
            $member->name,
            $member->email,
            $member->profile->student_id ?? '',
            $member->profile->course ?? '',
            $member->profile->year_level ?? '',
            $member->profile->phone ?? '',
            $member->profile->address ?? '',
        ];
    }
}