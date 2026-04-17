<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder dalam urutan yang benar
        $this->call([
            AgamaSeeder::class,
            PangkatSeeder::class,
            JabatanSeeder::class,
            EselonSeeder::class,
            PegawaiSeeder::class,
            UserSeeder::class,
        ]);
    }
}