<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pangkatData = [
            ['nama' => 'Juru Muda', 'golongan' => 'I/a', 'aktif' => 'Y'],
            ['nama' => 'Juru Muda Tingkat I', 'golongan' => 'I/b', 'aktif' => 'Y'],
            ['nama' => 'Juru', 'golongan' => 'I/c', 'aktif' => 'Y'],
            ['nama' => 'Juru Tingkat I', 'golongan' => 'I/d', 'aktif' => 'Y'],
            ['nama' => 'Penata Muda', 'golongan' => 'II/a', 'aktif' => 'Y'],
            ['nama' => 'Penata Muda Tingkat I', 'golongan' => 'II/b', 'aktif' => 'Y'],
            ['nama' => 'Penata', 'golongan' => 'II/c', 'aktif' => 'Y'],
            ['nama' => 'Penata Tingkat I', 'golongan' => 'II/d', 'aktif' => 'Y'],
            ['nama' => 'Penata Muda', 'golongan' => 'III/a', 'aktif' => 'Y'],
            ['nama' => 'Penata Muda Tingkat I', 'golongan' => 'III/b', 'aktif' => 'Y'],
            ['nama' => 'Penata', 'golongan' => 'III/c', 'aktif' => 'Y'],
            ['nama' => 'Penata Tingkat I', 'golongan' => 'III/d', 'aktif' => 'Y'],
            ['nama' => 'Pembina', 'golongan' => 'IV/a', 'aktif' => 'Y'],
            ['nama' => 'Pembina Tingkat I', 'golongan' => 'IV/b', 'aktif' => 'Y'],
            ['nama' => 'Pembina Utama Muda', 'golongan' => 'IV/c', 'aktif' => 'Y'],
            ['nama' => 'Pembina Utama Madya', 'golongan' => 'IV/d', 'aktif' => 'Y'],
            ['nama' => 'Pembina Utama', 'golongan' => 'IV/e', 'aktif' => 'Y'],
        ];

        foreach ($pangkatData as $pangkat) {
            \App\Models\Pangkat::create($pangkat);
        }
    }
}
