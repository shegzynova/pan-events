<?php

namespace App\Exports;

use App\Models\Hotel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HotelExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function array(): array
    {
        $hotels = Hotel::latest()->get();
        $processedHotels = [];

        foreach( $hotels AS $index => $hotel ){
            $hotelArray = $hotel;
            $hotelArray = $hotelArray->toArray();
            unset($hotelArray['event_id']); unset($hotelArray['event_id']);
            $hotelArray['event'] = optional($hotel->event)->title;
            $hotelArray['price'] = number_format($hotel->price);
            $hotelArray['created_at'] = $hotel->created_at->format('d M, Y H:i:s');
            $hotelArray['updated_at'] = $hotel->updated_at->format('d M, Y H:i:s');

            $processedHotels[] = $hotelArray;
        }

        return $processedHotels;
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Address',
            'Contact',
            'Price',
            'No Rooms Available',
            'Date Created',
            'Date Updated',
            'Event',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = Hotel::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:I'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
