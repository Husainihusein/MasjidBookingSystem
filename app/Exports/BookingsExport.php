<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Booking::query();

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get([
            'id',
            'name',
            'email',
            'phone',
            'booking_date',
            'start_time',
            'end_time',
            'purpose',
            'status',
            'created_at'
        ]);
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Phone', 'Date', 'Start Time', 'End Time', 'Purpose', 'Status', 'Created At'];
    }
}
