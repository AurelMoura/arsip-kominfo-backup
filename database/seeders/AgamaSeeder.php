<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agamaData = [
            ['nama' => 'Islam', 'aktif' => 'Y'],
            ['nama' => 'Kristen', 'aktif' => 'Y'],
            ['nama' => 'Katolik', 'aktif' => 'Y'],
            ['nama' => 'Hindu', 'aktif' => 'Y'],
            ['nama' => 'Buddha', 'aktif' => 'Y'],
        ];

        foreach ($agamaData as $agama) {
            \App\Models\Agama::create($agama);
        }
    }
}
