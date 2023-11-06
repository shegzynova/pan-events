<?php

namespace App\Exports;

use App\Models\EventUser;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventUsersExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $data = EventUser::latest()->get();
        $processedData = [];

        foreach( $data AS $index => $each ){

            $processedData[] = [
                'index' => $index+1,
                'user' => optional(optional($each)->user)->full_name,
                'event' => optional(optional($each)->event)->title,
                'title' => ucfirst($each->title ?? ""),
                'first_name' => $each->first_name,
                'surname' => $each->surname,
                'phone_number' => $each->phone_number,
                'email' => $each->email,
                'gender' => $each->gender,
                'nature_practice' => $each->nature_practice,
                'institution' => $each->institution,
                'city' => $each->city,
                'state' => optional(optional($each)->state_name)->name,
                'nationality' => optional(optional($each)->country)->name,
                'paid' => $each->paid ? 'Paid' : 'Not Paid',
                'amount' => $each->total_amount,
                'payment_ref' => $each->payment_ref
            ];
        }

        return $processedData;
    }

    public function headings(): array
    {
        return [
            '#',
            'User',
            'Event',
            'Title',
            'First Name',
            'Surname',
            'Phone Number',
            'Email',
            'Gender',
            'Nature of Practice',
            'Institution',
            'City',
            'State',
            'Nationality',
            'Status',
            'Amount',
            'Payment Ref'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = EventUser::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:Q'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}

