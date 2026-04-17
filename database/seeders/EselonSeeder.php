<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Eselon;

class EselonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eselons = [
            ['nama' => 'Eselon I', 'eselon' => 'I', 'aktif' => 'Y'],
            ['nama' => 'Eselon II', 'eselon' => 'II', 'aktif' => 'Y'],
            ['nama' => 'Eselon III', 'eselon' => 'III', 'aktif' => 'Y'],
            ['nama' => 'Eselon IV', 'eselon' => 'IV', 'aktif' => 'Y'],
            ['nama' => 'Jabatan Fungsional Tertentu', 'eselon' => 'JFT', 'aktif' => 'Y'],
            ['nama' => 'Jabatan Fungsional Umum', 'eselon' => 'JFU', 'aktif' => 'Y'],
        ];

        foreach ($eselons as $eselon) {
            Eselon::create($eselon);
        }
    }
}
