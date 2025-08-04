<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StagiaireReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $stagiaire;
    public $deadlineColumn;
    public $date;

    public function __construct($stagiaire, $deadlineColumn, $date)
    {
        $this->stagiaire = $stagiaire;
        $this->deadlineColumn = $deadlineColumn;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Stagiaire Reminder Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $daysRemaining = $this->date->diffInDays(now());
        $message = 'Ceci est un rappel. Le délai pour déposer votre rapport du ' .
            __('message.'.$this->deadlineColumn) .
            ' est : ' . $this->date->format('d/m/Y') . '. Il vous reste ' . $daysRemaining . ' jours.';

        return new Content(
            view: 'email.stagiaire_reminder',
            with: [
                'message'=>$message,
            ],
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
