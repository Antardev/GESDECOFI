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
            'fullname' => 'Admin Admin',
            'email' => 'decofiadmin@decofi.com',
            'email_verified_at' => now(),
            'password' => Hash::make('DECOfi1234'),
            'lang' => 'fr',
            'validated_type' => 'admin',
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'fullname' => 'SUPER Admin',
            'email' => 'decofisuperadmin@decofi.com',
            'email_verified_at' => now(),
            'password' => Hash::make('DECOfi1234'),
            'lang' => 'fr',
            'validated_type' => 'superadmin',
            'role' => 'superadmin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}


?>