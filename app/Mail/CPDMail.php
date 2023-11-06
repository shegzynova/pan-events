<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CPDMail extends Mailable
{
    use Queueable, SerializesModels;

    protected array $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('CPD Certificate for '. $this->data['event'])->view('emails.cpd', $this->data)
            ->attach($this->data['certificate'], [
                'as' => 'certificate.png',
                'mime' => 'image/png',
            ]);
    }
}
