<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Stagiaire;

class CabinetReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $stagiaire;
    public $semesterStartDate;

    /**
     * Create a new message instance.
     */
    public function __construct( Stagiaire $stagiaire)
    {
        $this->stagiaire = $stagiaire;
        $this->semesterStartDate = Carbon::parse($stagiaire->semester_2_begin);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informations requises pour votre deuxième année',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.CabinetReminder',
            with : [
                'stagiaire' => $this->stagiaire,
                'semesterStartDate' => $this->semesterStartDate,
            ]

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
