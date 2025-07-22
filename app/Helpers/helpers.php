<?php

use App\Models\GeneralConfig;
use App\Models\StagiaireNumberJt;
use App\Models\Stagiaire;
use App\Models\ControleurAssistant;


use Illuminate\Support\Facades\Cache;

if (!function_exists('truncateParagraph')) {
    function truncateParagraph($paragraph, $maxLength = 32) {
        if (strlen($paragraph) > $maxLength) {
            return substr($paragraph, 0, $maxLength) . '...';
        }
        return $paragraph;
    }
}

if (!function_exists('get_general_config')) {
    function get_general_config() {

        $general = Cache::remember('gen_conf', 86400, function() {
            $general = GeneralConfig::where('id', 1)->first();
            return $general;
        });

        return $general;
    }
}

if (!function_exists('get_st_total_jt_number')) {
    function get_st_total_jt_number() {

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        return $stagiaire->jt_number;

    }
}


if (!function_exists('get_stagiaire')) {
    function get_stagiaire() {

        $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        return $stagiaire;

    }
}


if (!function_exists('get_assistant')) {
    function get_assistant() {

        $stagiaire = ControleurAssistant::where('user_id', auth()->id())->first();

        return $stagiaire;

    }
}

if (!function_exists('getJTtoDisplay')) {
    function getJTtoDisplay($semestre, $getJtDone, $jtNumber) {
        
        $tor = 1;

        if (!in_array($semestre, ['1', '2', '3', '4', '5', '6'])) {
            throw new Exception('Semestre invalide');
        }

        if($semestre == '1' || $semestre == '2')
        {

            $norm = $jtNumber - get_general_config()->jt_number*2;
            $tor = $norm - $getJtDone;

        } else if($semestre == '3' || $semestre == '4')
        {
            $norm = $jtNumber - get_general_config()->jt_number*1;
            $tor = $norm - $getJtDone;

        }  else if($semestre == '5' || $semestre == '6')
        {
            $norm = $jtNumber - get_general_config()->jt_number*1;
            $tor = $norm - $jtNumber;

        }

        if($tor<0)
        {
            $tor = 3;
        }

        return $jtNumber - get_general_config()->jt_number*3 +3;
    }
}

?>