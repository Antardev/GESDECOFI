<?php
namespace App\Exports;

use App\Models\Stagiaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StagiairesExport implements FromCollection, WithHeadings, WithColumnFormatting, WithTitle, WithEvents
{
    protected $country;
    protected $year;

    public function __construct($country = null, $year = null)
    {
        $this->country = $country;
        $this->year = $year;
    }

    public function collection()
    {
        // Votre logique de récupération des stagiaires, inchangée
        if ($this->country) {
            if ($this->year) {
                $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'numero_cnss', 'stage_begin', 'nom_maitre', 'prenom_maitre', 'nom_cabinet', 'birthdate', 'country', 'validated')
                    ->where('country', $this->country)
                    ->where('year', $this->year)
                    ->get();
            } else {
                $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'numero_cnss', 'stage_begin', 'nom_maitre', 'prenom_maitre', 'nom_cabinet', 'birthdate', 'country', 'validated')
                    ->where('country', $this->country)
                    ->get();
            }
        } else {
            if ($this->year) {
                $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'numero_cnss', 'stage_begin', 'nom_maitre', 'prenom_maitre', 'nom_cabinet', 'birthdate', 'country', 'validated')
                    ->where('year', $this->year)
                    ->get();
            } else {
                $stagiaires = Stagiaire::select('matricule', 'firstname', 'name', 'email', 'phone', 'numero_cnss', 'stage_begin', 'nom_maitre', 'prenom_maitre', 'nom_cabinet', 'birthdate', 'country', 'validated')
                    ->get();
            }
        }

        // Convertir le matricule en chaîne pour éviter la notation scientifique
        return $stagiaires->map(function ($stagiaire) {
            return [
                'matricule' => (string) $stagiaire->matricule,
                'firstname' => $stagiaire->firstname,
                'name' => $stagiaire->name,
                'email' => $stagiaire->email,
                'phone' => $stagiaire->phone,
                'numero_cnss' => $stagiaire->numero_cnss . ' ',
                'stage_begin' => $stagiaire->stage_begin,
                'nom_maitre' => $stagiaire->nom_maitre . ' ' . $stagiaire->prenom_maitre,
                'nom_cabinet' => $stagiaire->nom_cabinet,
                'birthdate' => $stagiaire->birthdate,
                'country' => $stagiaire->country,
                'validated' => $stagiaire->validated ? 'OUI' : 'NON',
            ];
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

    public function title(): string
    {
        return 'Liste des stagiaires du ' . ($this->country ?? 'Tous les pays') . ($this->year ? ' Année ' . $this->year : '');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $title = 'Liste des stagiaires du ' . ($this->country ?? 'Tous les pays') . ($this->year ? ' Année ' . $this->year : '');

                // Ajouter le titre à la première ligne
                $sheet->setCellValue('A1', $title);
                $sheet->mergeCells('A1:L1'); // Fusionner les cellules pour le titre
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Appliquer le style
                $sheet->getRowDimension(1)->setRowHeight(20); // Ajuster la hauteur de la ligne

                // Déplacer les en-têtes à la ligne 2
                $event->sheet->getDelegate()->fromArray($this->headings(), NULL, 'A2');

                // Ajouter les données des stagiaires à partir de la ligne 3
                $data = $this->collection()->toArray();
                $event->sheet->getDelegate()->fromArray($data, NULL, 'A3');
            }
        ];
    }
}

?>