<?php

namespace App\Exports;

use App\Models\Reservations;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReservationExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $data = Reservations::latest()->get();
        $processedData = [];

        foreach( $data AS $index => $each ){

            $processedData[] = [
                'index' => $index+1,
                'event' => optional($each->event)->title,
                'hotel' => optional(optional($each)->hotel)->name,
                'user' => $each->user->full_name,
                'email' => $each->user->email,
                'phone' => $each->user->phone,
                'quantity' => $each->quantity,
                'costPerNight' => ($each->total_amount ?? 0) / ($each->quantity ?? 1),
                'total_amount' => $each->total_amount,
                'isPaid' => $each->isPaid ? 'Paid' : 'Reserved',
                'ref' => optional($each->transaction)->transaction_reference ?? ($each->payment_ref ?? "N/A"),
            ];
        }

        return $processedData;
    }

    public function headings(): array
    {
        return [
            '#',
            'Event',
            'Hotel',
            'User',
            'Email',
            'Phone Number',
            'Number of Nights',
            'Cost Per Night',
            'Total Amount',
            'Status',
            'Payment Ref.',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = Reservations::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:K'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
