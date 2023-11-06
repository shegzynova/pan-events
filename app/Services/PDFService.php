<?php
// app/Services/SMSService.php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class PDFService
{

    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function downloadPDF($view)
    {
        $pdf = Pdf::loadView($view, $this->data);

        return $pdf->download($this->data['title'] .'.pdf');
    }
}
