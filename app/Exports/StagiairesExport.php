<?php

namespace App\Exports;

use App\Models\Stagiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StagiairesExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    protected $country;

    public function __construct($country = null)
    {
        if($country)
        {
            $this->country = $country;
        }
    }

    public function collection()
    {
        if($this->country)
        {
            $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'numero_cnss', 'stage_begin', 'nom_maitre', 'prenom_maitre', 'nom_cabinet', 'birthdate', 'country', 'validated')
                ->where('country', $this->country)
                ->get();
        } else {
            $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'numero_cnss', 'stage_begin', 'nom_maitre', 'prenom_maitre',  'nom_cabinet', 'birthdate', 'country', 'validated')
                ->get();
        }

        // Convertir le matricule en chaîne pour éviter la notation scientifique
        return $stagiaires->map(function ($stagiaire) {
            $st = new Stagiaire();
            $st->matricule = (string) $stagiaire->matricule;
            $st->firstname = $stagiaire->firstname;
            $st->name = $stagiaire->name;
            $st->email = $stagiaire->email;
            $st->phone = $stagiaire->phone;
            $st->numero_cnss = $stagiaire->numero_cnss.' ';
            $st->stage_begin = $stagiaire->stage_begin;
            $st->nom_maitre = $stagiaire->nom_maitre.' '.$stagiaire->prenom_maitre;
            $st->nom_cabinet = $stagiaire->nom_cabinet;
            $st->birthdate = $stagiaire->birthdate;
            $st->country = $stagiaire->country;
            $st->validated = $stagiaire->validated?'OUI':'NON';
            return $st;
        });
    }

    public function headings(): array
    {
        return ['Matricule', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Numéro Cnss', 'Début de stage', 'Maître de stage', 'Cabinet', 'Date de naissance', 'Pays', 'Validé'];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Force le format texte pour la colonne Matricule
        ];
    }
}