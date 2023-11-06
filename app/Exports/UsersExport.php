<?php

namespace App\Exports;

use App\Models\Hotel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $data = User::latest()->get();
        $processedData = [];

        foreach( $data AS $index => $each ){

            $processedData[] = [
                'index' => $index+1,
                'first_name' => $each->first_name,
                'last_name' => $each->last_name,
                'username' => $each->username,
                'phone' => $each->phone,
                'email' => $each->email,
                'user_type' => ucwords(str_replace('_',' ',  $each->user_type)),
                'role' => ucfirst($each->getRoleNames()->first())
            ];
        }

        return $processedData;
    }

    public function headings(): array
    {
        return [
            '#',
            'First Name',
            'Last Name',
            'Username',
            'Phone',
            'Email',
            'User Type',
            'Role',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = User::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:H'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
