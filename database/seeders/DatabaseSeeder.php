<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(CategorieSeeder::class);
        $this->call(SubCategorieSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(AffiliationOrderTableSeeder::class);
        $this->call(GeneralConfigTableSeeder::class);
        $this->call(DomainTableSeeder::class);
        $this->call(SubDomainTableSeeder::class);

    }
}
