<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['categorie_name' => 'Travaux de base'],
            ['categorie_name' => 'Mission de conseil'],
            ['categorie_name' => 'Mission d\'Audit et de commissariat aux comptes'],
            ['categorie_name' => 'Expertise judiciaire'],
            ['categorie_name' => 'Gestion du Cabinet'],
        ];

        DB::table('categories')->insert($categories);
    }
}
