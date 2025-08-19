<?php

use App\Models\GeneralConfig;
use App\Models\StagiaireNumberJt;
use App\Models\Stagiaire;
use App\Models\Controleurs;
use App\Models\Rapport;
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
    function get_st_total_jt_number($id = null) {

        if($id)
        {
            $stagiaire = Stagiaire::where('id', $id)->first();

        }else
        {
            $stagiaire = Stagiaire::where('user_id', auth()->id())->first();

        }

        return $stagiaire->jt_number;

    }
}


if (!function_exists('getYearFromRapportName')) {
    function getYearFromRapportName($name = null)
    {
        switch ($name) {
            case 'R1':
            case 'R2':
                return 1;
            case 'R3':
            case 'R4':
                return 2;
            case 'R5':
            case 'R6':
                return 3;
            default:
                return null;
        }
    }
}

if (!function_exists('get_stagiaire')) {
    function get_stagiaire($id = null) {

        $stagiaire = null;
        
        if($id)
        {
            $stagiaire = Stagiaire::where('id', $id)->first();

        }else
        {
            $stagiaire = Stagiaire::where('user_id', auth()->id())->first();
        }
            return $stagiaire;

    }
}


if (!function_exists('get_assistant')) {
    function get_assistant($id = null) {

        $assistant = null;
        if($id)
        {
            $assistant = ControleurAssistant::where('id', $id)->first();

        } else
        {
            $assistant = ControleurAssistant::where('user_id', auth()->id())->first();

        }

        return $assistant;

    }
}


if (!function_exists('get_controleur')) {
    function get_controleur($id = null) {

        $controleur = null;

        if($id)
        {
            $controleur = Controleurs::where('id', $id)->first();

        } else
        {
            $controleur = Controleurs::where('user_id', auth()->id())->first();

        }

        return $controleur;

    }
}

if (!function_exists('get_controleur_diligence_ins')) {
    function get_controleur_diligence_ins() 
    {
        $r = get_controleur_or_assistant();
        if(isset($r['assistant']) && $r['assistant'])
        {
            $country = $r['assistant']->country;

        } else $country = $r['controller']->country_contr;

        $n = Stagiaire::where('country', $country)->where('validated', false)->count();

        return $n?$n:0;
    }
}

if (!function_exists('get_controleur_diligence_rap')) {
    function get_controleur_diligence_rap() 
    {
        $r = get_controleur_or_assistant();
        if(isset($r['assistant']) && $r['assistant'])
        {
            $country = $r['assistant']->country;

        } else $country = $r['controller']->country_contr;

            $s = Stagiaire::where('country', $country)->pluck('id');
            $n = Rapport::where('validated', false)->whereIn('stagiaire_id', $s)->count();
        //$n = Stagiaire::where('country', $country)->where('validated', false);

        return $n?$n:0;
    }
}


if (!function_exists('get_controleur_or_assistant')) {
    function get_controleur_or_assistant() {

        $controller = Controleurs::where('user_id', auth()->id())->first();
        $assistant = null;

        $r = [];

        if(!$controller)
        {
            $assistant = get_assistant();
            if($assistant)
            {
                $assistant = get_assistant();
                $r['assistant'] = $assistant;
            }
        } elseif($controller)
        {
            $r['controller'] = $controller;
        }

        if (!$assistant && !$controller)
        {
            return null;
        }

        return $r;

    }
}


if (!function_exists('get_country_controleur_and_assistant')) {
    function get_country_controleur_and_assistant() {
        $country_contr = "" ;
        $r = get_controleur_or_assistant();

        if(!empty($r['controller']))
        {
            $country = $r['controller']->country_contr;

        } elseif(!empty($r['assistant']))
        {
            $assistant = $r['assistant'];
            $country = $assistant->controleur->country_contr;
        } else
        {
            return null;
        }

        return $country;

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