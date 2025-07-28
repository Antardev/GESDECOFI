<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id'=>1, 'name'=>'Valider_Stagiaire', 'type'=> 'assistant'],
            ['id'=>2, 'name'=>'Voir_Missions', 'type'=> 'assistant'],
            ['id'=>3, 'name'=>'Voir_JT', 'type'=> 'assistant'],
            ['id'=>4, 'name'=>'Valider_année', 'type'=> 'assistant'],
        ];

        DB::table('roles')->insert($roles);
    }
}
