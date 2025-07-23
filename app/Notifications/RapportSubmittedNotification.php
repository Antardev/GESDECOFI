<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RapportSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     protected $rapport;
    protected $stagiaire;
    public function __construct($rapport, $stagiaire)
    {
        $this->rapport = $rapport;
        $this->stagiaire = $stagiaire;
    }   
  

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Un stagiaire a soumis un rapport.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
                'message' => "Nouveau rapport soumis par {$this->stagiaire->name}",
                'rapport_id' => $this->rapport->id,
                'stagiaire_id' => $this->stagiaire->id,
                'link' => route('controleur.rapport_history', $this->stagiaire->id),
        ];
    }
}
