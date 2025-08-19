<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Stagiaire;
use function route;

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
            ->subject('Nouvelle inscription de stagiaire')
            ->greeting('Bonjour,')
            ->line('Un nouveau stagiaire s\'est inscrit:')
            ->line('Nom: ' . $this->stagiaire->name)
            ->line('Email: ' . $this->stagiaire->email)
            ->line('Matricule: ' . $this->stagiaire->matricule)
            ->action('Voir la demande', route('CN.diligences_table').'?a=sav')
            ->line('Merci de traiter cette demande dans les plus brefs délais.')
            ->salutation('Cordialement');
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
            'message' =>  $this->stagiaire->name . ' s\'est inscrit, veillez valider' ,
            'link' => route('CN.diligences_table'). '?a=sav',
    
        ];
    }
}
