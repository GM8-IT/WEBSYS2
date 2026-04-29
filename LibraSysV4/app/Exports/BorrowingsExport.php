<?php

namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Borrowing::with('user', 'bookCopy.book')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'Member',
            'Email',
            'Book',
            'Accession Number',
            'Borrowed At',
            'Due At',
            'Returned At',
            'Fine Amount',
            'Status',
        ];
    }

    public function map($borrowing): array
    {
        return [
            $borrowing->user->name,
            $borrowing->user->email,
            $borrowing->bookCopy->book->title,
            $borrowing->bookCopy->accession_number,
            $borrowing->borrowed_at?->format('Y-m-d'),
            $borrowing->due_at?->format('Y-m-d'),
            $borrowing->returned_at?->format('Y-m-d') ?? 'Not returned',
            $borrowing->fine_amount,
            $borrowing->status,
        ];
    }
}