<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliationOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $affiliation_orders = [
            ['id'=>1, 'name'=>'OECCA Bénin', 'country'=> 'Benin', 'principal_city' => 'Cotonou'],
            ['id'=>2, 'name'=>'OEC Côte d\'Ivoire', 'country'=> 'Ivory-Coast', 'principal_city' => 'Abidjan'],
            ['id'=>3, 'name'=>'ONECCA Burkina', 'country'=> 'Burkina-Faso', 'principal_city' => 'Ouagadjougou'],
            ['id'=>4, 'name'=>'OECCA Guinée Bissau', 'country'=> 'Guinea-Bissau', 'principal_city' => '..'],
            ['id'=>5, 'name'=>'ONECCA Niger', 'country'=> 'Niger', 'principal_city' => 'Niamey'],
            ['id'=>6, 'name'=>'ONECCA Mali', 'country'=> 'Mali', 'principal_city' => 'Bamako'],
            ['id'=>7, 'name'=>'ONECCA Sénégal', 'country'=> 'Senegal', 'principal_city' => 'Dakar'],
            ['id'=>8, 'name'=>'ONECCA Togo', 'country'=> 'Togo', 'principal_city' => 'Lome'],

        ];

        DB::table('affiliation_orders')->insert($affiliation_orders);
    }
}
