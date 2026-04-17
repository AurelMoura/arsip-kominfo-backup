<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanData = [
            // Struktural
            ['id' => 1, 'jenis_jabatan' => 'struktural', 'eselon' => 'II.a', 'nama_jabatan' => 'Kepala Dinas Kominfo', 'aktif' => 'Y'],
            ['id' => 2, 'jenis_jabatan' => 'struktural', 'eselon' => 'II.b', 'nama_jabatan' => 'Sekretaris Dinas Kominfo', 'aktif' => 'Y'],
            ['id' => 3, 'jenis_jabatan' => 'struktural', 'eselon' => 'III.b', 'nama_jabatan' => 'Kepala Bidang Informasi dan Komunikasi Publik', 'aktif' => 'Y'],
            ['id' => 4, 'jenis_jabatan' => 'struktural', 'eselon' => 'III.b', 'nama_jabatan' => 'Kepala Bidang Teknologi Informasi dan Komunikasi', 'aktif' => 'Y'],
            ['id' => 5, 'jenis_jabatan' => 'struktural', 'eselon' => 'III.b', 'nama_jabatan' => 'Kepala Bidang Statistik dan Persandian', 'aktif' => 'Y'],
            ['id' => 6, 'jenis_jabatan' => 'struktural', 'eselon' => 'IV.a', 'nama_jabatan' => 'Kepala Seksi Pengelolaan Informasi Publik', 'aktif' => 'Y'],

            // Fungsional Tertentu (JFT)
            ['id' => 7,  'jenis_jabatan' => 'JFT', 'eselon' => null, 'nama_jabatan' => 'Pranata Komputer Ahli Pertama', 'aktif' => 'Y'],
            ['id' => 8,  'jenis_jabatan' => 'JFT', 'eselon' => null, 'nama_jabatan' => 'Pranata Komputer Ahli Muda', 'aktif' => 'Y'],
            ['id' => 9,  'jenis_jabatan' => 'JFT', 'eselon' => null, 'nama_jabatan' => 'Pranata Humas Ahli Pertama', 'aktif' => 'Y'],
            ['id' => 10, 'jenis_jabatan' => 'JFT', 'eselon' => null, 'nama_jabatan' => 'Statistisi Ahli Pertama', 'aktif' => 'Y'],
            ['id' => 11, 'jenis_jabatan' => 'JFT', 'eselon' => null, 'nama_jabatan' => 'Sandiman Ahli Pertama', 'aktif' => 'Y'],
        ];

        foreach ($jabatanData as $data) {
            Jabatan::updateOrCreate(
                ['id' => $data['id']],
                collect($data)->except('id')->toArray()
            );
        }
    }
}
