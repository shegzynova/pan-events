<?php

// app/Services/EmailService.php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendEmailWithReceipt($to, $subject, $view, $data = [])
    {

        Mail::send($view, $data, function ($message) use ($to, $subject, $data) {
            $pdf = Pdf::setPaper('letter')->loadView('receipt', $data);


            // Attach PDF to email
            $message->to($to)
                ->subject($subject)
                ->attachData($pdf->output(), 'my_receipt.pdf', [
                    'mime' => 'application/pdf',
                ]);
        });

    }

    public function sendEmail($to, $subject, $view, $data = [])
    {

        Mail::send($view, $data, function ($message) use ($to, $subject, $data) {

            // Attach PDF to email
            $message->to($to)
                ->subject($subject);
        });

    }

}

