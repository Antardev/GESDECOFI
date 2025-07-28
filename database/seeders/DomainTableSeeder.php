<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domains = [
            'Missions comptables et spécifiques',
            'Missions de Commissariat aux comptes',
            'Management du cabinet',
            'Missions d\'assistance juridique et fiscale',
            'Audit des institutions de micro finance',
            'Gestion financière et audit des projets',
            'Missions de conseil en gestion',
            'Pratiques professionnelles',
            'Autres missions',
            'Préparation du mémoire',
            'Missions informatique et d\'organisation',
        ];

        $a = 1;
        foreach ($domains as $domain) {
            DB::table('domains')->insert([
                'id' => $a,
                'name' => $domain,
                'description' => null, // ou une description par défaut si nécessaire
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $a++;
        }
    }
}
