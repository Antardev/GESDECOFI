<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StagiaireDemandeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stagiaire;

    /**
     * Create a new message instance.
     */

    public function __construct($stagiaire)
    {
        $this->stagiaire = $stagiaire;
    }

    public function build()
    {
        return $this->subject("Confirmation de votre demande de stage")->view('email.stagiaire_demande');
    }

}
