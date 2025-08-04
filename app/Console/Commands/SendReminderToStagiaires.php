<?php

namespace App\Console\Commands;

use App\Mail\StagiaireReminderEmail;
use App\Models\Stagiaire;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReminderToStagiaires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminder-to-stagiaires';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    {
        $today = now(); // Obtenez la date actuelle

        // Vérifiez chaque semestre
        for ($i = 0; $i <= 5; $i++) 
        {
            $deadlineColumn = "dead_{$i}_semester";
            $stagiaires = Stagiaire::whereNotNull($deadlineColumn)
                ->where($deadlineColumn, '<=', $today)
                ->get();

            foreach ($stagiaires as $stagiaire) 
            {
                // Envoi du premier rappel
                Mail::to($stagiaire->email)->send(new StagiaireReminderEmail($stagiaire, $deadlineColumn, $today));

                // Envoi du second rappel 3 mois après la date limite
                $threeMonthsLater = \Carbon\Carbon::parse($stagiaire->$deadlineColumn)->addMonths(3);
                if ($threeMonthsLater <= $today) 
                {
                    Mail::to($stagiaire->email)->send(new StagiaireReminderEmail($stagiaire, $deadlineColumn, $threeMonthsLater));
                }
            }
        }

        $this->info('Rappels envoyés avec succès.');
        }
    }
}
