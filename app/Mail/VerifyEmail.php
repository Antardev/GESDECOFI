<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $url;
    /**
     * Create a new message instance.
     */
    public function __construct($notifiable, $url)
    {
        $this->user = $notifiable;

        $this->url = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('message.email_verification'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $content = new Content();
        $content->view = 'email.verification-email';
        $content->with([
            'user' => $this->user,
            'verificationUrl' => $this->url,
        ]);

        return $content;

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
