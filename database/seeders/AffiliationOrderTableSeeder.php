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
            ['id'=>1, 'name'=>'OECCA Bénin', 'country'=> 'Benin'],
            ['id'=>2, 'name'=>'OEC Côte d\'Ivoire', 'country'=> 'Ivory-Coast'],
            ['id'=>3, 'name'=>'ONECCA Burkina', 'country'=> 'Burkina-Faso'],
            ['id'=>4, 'name'=>'OECCA Guinée Bissau', 'country'=> 'Guinea-Bissau'],
            ['id'=>5, 'name'=>'ONECCA Niger', 'country'=> 'Niger'],
            ['id'=>6, 'name'=>'ONECCA Mali', 'country'=> 'Mali'],
            ['id'=>7, 'name'=>'ONECCA Sénégal', 'country'=> 'Senegal'],
            ['id'=>8, 'name'=>'ONECCA Togo', 'country'=> 'Togo'],

        ];

        DB::table('affiliation_orders')->insert($affiliation_orders);
    }
}
