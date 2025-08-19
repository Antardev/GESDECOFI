<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StagiaireRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $firstname;
    public $email;
    public $matricule;
    public $phone;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
       $this->name = $data['name']; // Assuming 'stagiaire' is passed in the data array
        $this->firstname = $data['prenom']; // Assuming 'prenom' is passed in the data array
        $this->email = $data['email']; // Assuming 'email' is passed in the data array
        $this->matricule = $data['matricule']; // Assuming 'matricule' is passed in the data array
        $this->phone = $data['phone']; // Assuming 'phone' is passed in the data array
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscription d\'un stagiaire',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.RegisteredStagiaireMail',
            with: [
                'name' => $this->name,
                'firstname' => $this->firstname,
                'email' => $this->email,
                'matricule' => $this->matricule,
                'phone' => $this->phone
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
