<?php

namespace App\Exports;

use App\Models\AbstractModel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbstractsExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $data = AbstractModel::latest()->get();
        $processedData = [];

        $statusMapping = [
            'p' => 'Pending',
            'a' => 'Approved',
            'd' => 'Declined',
        ];

        foreach ($data as $index => $each) {
            $processedData[] = [
                'index' => $index + 1,
                'full_name' => $each->full_name,
                'contact_phone_number' => $each->contact_phone_number,
                'email' => $each->email,
                'no_of_pages' => $each->no_of_pages,
                'abstract_title' => $each->abstract_title,
                'duration' => $each->duration,
                'status' => $statusMapping[$each->status] ?? 'Unknown',
                'full_paper_status' => $statusMapping[$each->full_paper_status] ?? 'Unknown',
                'presentation_status' => $statusMapping[$each->presentation_status] ?? 'Unknown',
            ];
        }


        return $processedData;
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Phone Number',
            'Email',
            'No Of Pages',
            'Abstract Title',
            'Duration',
            'Abstract Status',
            'Full Paper Status',
            'Presentation Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = AbstractModel::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:J' . $totalCount + 1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
