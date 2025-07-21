<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('general_configs')->insert([
            'jt_number' => 3,
            'semester_number' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
