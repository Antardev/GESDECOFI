<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StageBeginUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $firstname;
    public $email;
    public $matricule;
    public $new_date;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->name = $data['name']; // Placeholder, should be set when sending the email
        $this->firstname = $data['firstname']; // Placeholder, should be set when sending the email
        $this->email = $data['email']; // Placeholder, should be set when sending the email
        $this->matricule = $data['matricule']; // Placeholder, should be set when sending the email
        $this->new_date = $data['new_date']; // Placeholder, should be set when sending the email
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour de votre date de début de stage',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.StageBeginUpdateMail',
            with: [
                'name' => $this->name,
                'firstname' => $this->firstname,
                'email' => $this->email,
                'matricule' => $this->matricule,
                'new_date' => $this->new_date
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
