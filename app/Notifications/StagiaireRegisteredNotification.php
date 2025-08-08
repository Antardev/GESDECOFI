<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Stagiaire;

class StagiaireRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The stagiaire instance.
     *
     * @var \App\Models\Stagiaire
     */

    protected $stagiaire;

    /**
     * Create a new notification instance.
     */
    public function __construct( Stagiaire $stagiaire)
    {
        $this->stagiaire= $stagiaire;
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
                    ->line('The introduction to the notification.')
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
            'title' => 'Inscription d\'un stagiaire',
            'message' => 'Un stagiaire s\' est inscrit : ' . $this->stagiaire->name . ' Veilez consulter la liste des stagiaires pour plus de détails.',
            'link' => route('CN.diligences_table'),
    
        ];
    }
}
