<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeAttestation extends Model
{
    use HasFactory;

     protected $fillable = [
        'numerodemande','civilite','matriculestagiaire','nomstagiaire','prenomstagiaire','lieunaissance','nationalite','adresse',
        'datenaissance','phonecontact','email','datedebutstage','datefinstage','prenomcontrolleurstage','prenomaitrestage',
        'orderaffimaitstage','numeroaffimaitstage','dateaffimaitstage','raisonsociastructure','ordreaffilistructure','numeroaffilistructure',
        'dateaffilistructure','conditions','rapports','journees',
    ];

    protected $casts = [
        'conditions' => 'array',
        'rapports'   => 'array',
        'journees'   => 'array',
        'datenaissance' => 'date',
        'datedebutstage' => 'date',
        'datefinstage' => 'date',
        'dateaffimaitstage' => 'date',
        'dateaffilistructure' => 'date',
    ];

    public static function genererNumeroDemande()
    {

        $annee = date('y');// Les deux derniers chiffres de l'année en cours
        // Récupérer le dernier numéro existant pour l'année en cours
        $last = self::where('numerodemande', 'like', $annee . '%')->orderBy('numerodemande', 'desc')->first();
        if ($last) {
            // Extraire la partie numérique après l'année
            $lastNumber = intval(substr($last->numerodemande, 2));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Première demande de l'année → commencer à 001
            $newNumber = '001';
        }
        return $annee . $newNumber;
    }

}
