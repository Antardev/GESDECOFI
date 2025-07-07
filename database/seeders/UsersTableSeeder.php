<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'fullname' => 'SUPER Admin',
            'email' => 'decofiadmin@decofi.com',
            'email_verified_at' => now(),
            'password' => Hash::make('DECOfi1234'),
            'lang' => 'fr',
            'type' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}


?>