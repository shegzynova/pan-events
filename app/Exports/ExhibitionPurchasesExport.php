<?php

namespace App\Exports;

use App\Models\ExhibitionPurchase;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExhibitionPurchasesExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $data = ExhibitionPurchase::latest()->get();
        $processedData = [];

        foreach( $data AS $index => $each ){

            $processedData[] = [
                'index' => $index+1,

                'event' => optional(optional(optional($each)->attendance)->event)->title,

                'exhibition' => optional($each->exhibition)->description . ' - ' . optional($each->exhibition)->category . ' - ' . optional(optional($each->exhibition)->type)->type,

                'attendee' => optional(optional($each)->attendance)->first_name . ' ' . optional(optional($each)->attendance)->surname,

                'email' => optional(optional(optional($each)->attendance)->user)->email,

                'paid' => $each->paid == 'paid' ? 'Paid' : 'Not Paid',

                'amount' => $each->total_amount,
            ];
        }

        return $processedData;
    }

    public function headings(): array
    {
        return [
            '#',
            'Event',
            'Exhibition',
            'Attendee Name',
            'Attendee Email',
            'Status',
            'Amount',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = ExhibitionPurchase::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:G'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
