<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Arsip;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'SK CPNS',
            'SK PNS',
            'SK KENAIKAN PANGKAT',
            'SK PANGKAT TERAKHIR',
            'SK ANJAB TERAKHIR',
            'SK BERKALA TERAKHIR',
            'SKP TERAKHIR',
            'KP 4',
            'TASPEN',
            'KARTU PEGAWAI (KARPEG)',
            'KARTU KELUARGA',
            'KTP',
            'NPWP',
            'BPJS',
            'AKTA KELAHIRAN',
            'IJAZAH',
            'PIAGAM DIKLAT',
            'SATIYA LENCANA',
            'KARIS (KARTU SUAMI/ISTRI)',
        ];

        foreach ($data as $nama) {
            Arsip::firstOrCreate(['nama' => $nama], ['aktif' => 'ya']);
        }
    }
}
