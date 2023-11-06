<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{

    public function array(): array
    {
        $events = Event::latest()->get()->toArray();
        $processedEvents = [];

        foreach( $events AS $event ){
            unset($event['description']);
            unset($event['unique_id']);
            unset($event['slug']);
            $event['category'] = $event['category'] == 'c' ? 'Conference' : 'Webinar';
            $event['is_published'] = $event['is_published'] ? 'Published' : 'Not Published';
            $event['created_at'] = date('d M, Y H:i:s', strtotime($event['created_at']));
            $event['updated_at'] = date('d M, Y H:i:s', strtotime($event['updated_at']));
            $processedEvents[] = $event;
        }

        return $processedEvents;
    }

    public function headings(): array
    {
        return [
            '#',
            'Title',
            'Location',
            'Ordinary Member Price',
            'Trainee Member Price',
            'Associate Member Price',
            'Date',
            'Category',
            'Image',
            'Status',
            'Date Created',
            'Date Updated'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalCount = Event::count();
        return [
            // Apply a bold font to the header row
            1 => ['font' => ['bold' => true]],

            // Apply a border to all cells in the worksheet
            'A1:N'.$totalCount+1 => ['borders' => ['allBorders' => ['borderStyle' => 'thin']]],
        ];
    }
}
