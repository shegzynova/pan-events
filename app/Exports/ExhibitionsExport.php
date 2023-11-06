<?php

namespace App\Exports;

use App\Models\Exhibition;
use App\Models\Reservations;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExhibitionsExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $data = Exhibition::latest()->get();
        $processedData = [];

        foreach( $data AS $index => $each ){

            $processedData[] = [
                'index' => $index+1,
                'category' => $each->category,
                'amount' => number_format($each->amount),
                'description' => $each->description,
                'type' => optional(optional($each)->type)->type,
            ];
        }

        return $processedData;
    }

    public function headings(): array
    {
        return [
            '#',
            'Category',
            'Amount',
            'Description',
            'Exhibition Type',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = Exhibition::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:E'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
