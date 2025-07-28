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
            $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'birthdate', 'country', 'validated')
                ->where('country', $this->country)
                ->get();
        } else {
            $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'birthdate', 'country', 'validated')
                ->get();
        }

        // Convertir le matricule en chaîne pour éviter la notation scientifique
        return $stagiaires->map(function ($stagiaire) {
            $stagiaire->matricule = (string) $stagiaire->matricule;
            return $stagiaire;
        });
    }

    public function headings(): array
    {
        return ['Matricule', 'Prénom', 'Nom', 'Email', 'Téléphone', 'Date de naissance', 'Pays', 'Validé'];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Force le format texte pour la colonne Matricule
        ];
    }
}