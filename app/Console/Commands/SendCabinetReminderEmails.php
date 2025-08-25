<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stagiaire;
use App\Mail\CabinetReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendCabinetReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-cabinet-reminder-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoyer des rappels aux stagiaires pour ajouter les informations du cabinet de 2ème année';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Date actuelle + 1 mois
        $oneMonthFromNow = Carbon::now()->addMonth();
        
        // Trouver les stagiaires avec structure_type = 'entreprise'
        // dont le début du 2ème semestre est dans 1 mois
        $stagiaires = Stagiaire::where('structure_type', 'entreprise')
            ->whereDate('semester_2_begin', '<=', $oneMonthFromNow)
            ->whereDate('semester_2_begin', '>', Carbon::now())
            ->whereNull('cabinet_second_year_reminded_at') // Pour éviter les rappels multiples
            ->get();

        foreach ($stagiaires as $stagiaire) {
            // Envoyer l'email
            Mail::to($stagiaire->email)->send(new CabinetReminderMail($stagiaire));
            
            // Marquer comme notifié pour éviter les doublons
            $stagiaire->cabinet_second_year_reminded_at = Carbon::now();
            $stagiaire->save();
            
            $this->info("Email envoyé à: {$stagiaire->email}");
        }

        $this->info("{$stagiaires->count()} emails de rappel envoyés.");
    }
}
