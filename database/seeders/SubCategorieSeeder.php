<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            // Catégorie 1: Travaux de base
            ['categorie_id' => 1, 'categorie_name' => 'Travaux de base', 'subcategorie_name' => 'Mission de tenue comptable'],
            // Ajoute d'autres sous-catégories comme ci-dessous
            ['categorie_id' => 1, 'categorie_name' => 'Travaux de base', 'subcategorie_name' => 'Revue comptable'],
            ['categorie_id' => 1, 'categorie_name' => 'Travaux de base', 'subcategorie_name' => 'Mission de présentation des comptes'],
            // Catégorie 2: Missions de Conseil
            ['categorie_id' => 2, 'categorie_name' => 'Missions de Conseil', 'subcategorie_name' => 'Assistance et conseil en organisation(procédures administratives et comptables, plan de comptes, etc.…)'],
            ['categorie_id' => 2, 'categorie_name' => 'Missions de Conseil', 'subcategorie_name' => 'Assistance et conseil en matière juridique (secrétariat juridique, restructuration, transmission de patrimoine, etc.…)'],
            ['categorie_id' => 2, 'categorie_name' => 'Missions de Conseil', 'subcategorie_name' => 'Assistance et conseil en matière sociale (bulletins de paie, déclarations sociales…)'],
            ['categorie_id' => 2, 'categorie_name' => 'Missions de Conseil', 'subcategorie_name' => 'Assistance et conseil en matière fiscale (établissement de déclarations fiscales, déclarations de résultats, etc.…)'],
            ['categorie_id' => 2, 'categorie_name' => 'Missions de Conseil', 'subcategorie_name' => 'Assistance et conseil en gestion (comptabilité analytique, analyse de coûts, tableaux de bord, études prévisionnelles,…)'],
            ['categorie_id' => 2, 'categorie_name' => 'Missions de Conseil', 'subcategorie_name' => 'Assistance et conseil en informatique (implantation de systèmes informatiques, choix de systèmes informatiques, etc.…)'],
            // Ajoute toutes les autres sous-catégories ici
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Orientation et planification de la mission'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Appréciation du contrôle interne'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Contrôle direct des comptes'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Travaux de fin de mission, note de synthèse, examen critique/revue analytique, comptes annuels'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Expression d\'opinion (rapports et attestations'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Vérifications spécifiques du Commissariat aux comptes'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Missions particulières connexes (apports, fusions, procédures d’alerte, etc.)'],
            ['categorie_id' => 3, 'categorie_name' => 'Mission d\'audit et de commissariat aux comptes', 'subcategorie_name' => 'Autres (vérification des comptes)'],
            ['categorie_id' => 4, 'categorie_name' => 'Expertise judiciaire', 'subcategorie_name' => 'Expertise judiciaire'],
            ['categorie_id' => 5, 'categorie_name' => 'Gestion du Cabinet', 'subcategorie_name' => 'Propositions de service'],
            ['categorie_id' => 5, 'categorie_name' => 'Gestion du Cabinet', 'subcategorie_name' => 'Formation'],
            ['categorie_id' => 5, 'categorie_name' => 'Gestion du Cabinet', 'subcategorie_name' => 'Assistance à la préparation des offres'],
            ['categorie_id' => 5, 'categorie_name' => 'Gestion du Cabinet', 'subcategorie_name' => 'Autres activités (à préciser) '],
            // Ajoute d'autres sous-catégories au besoin...
        ];

        DB::table('sub_categories')->insert($subCategories);
    }
}
