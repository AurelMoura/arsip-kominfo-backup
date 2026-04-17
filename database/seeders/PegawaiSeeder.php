<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get reference data
        $agamaIslam = \App\Models\Agama::where('nama', 'Islam')->first();
        $pangkatPembinaUtamaMadya = \App\Models\Pangkat::where('golongan', 'IV/d')->first();
        $pangkatPembinaUtama = \App\Models\Pangkat::where('golongan', 'IV/e')->first();
        $pangkatPembinaUntamaMuda = \App\Models\Pangkat::where('golongan', 'IV/c')->first();
        $jabatanKepalaDinas = \App\Models\Jabatan::where('nama', 'Kepala Dinas')->first();
        $jabatanPerawatAhliMuda = \App\Models\Jabatan::where('nama', 'Perawat Ahli Muda')->first();
        $jabatanStaffAdmin = \App\Models\Jabatan::where('nama', 'Staff Administrasi')->first();

        // Data Superadmin
        Pegawai::create([
            'id' => '0987654321',
            'nama_lengkap' => 'Superadmin Kominfo',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1980-01-01',
            'gol_darah' => 'O',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS',
            'agama_id' => $agamaIslam->id ?? 1,
            'pangkat_id' => $pangkatPembinaUtamaMadya->id ?? 1,
            'jabatan_id' => $jabatanKepalaDinas->id ?? 1,
        ]);
        
        // Data Admin
        Pegawai::create([
            'id' => '1111111111',
            'nama_lengkap' => 'Admin',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1985-05-15',
            'gol_darah' => 'A',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS',
            'agama_id' => $agamaIslam->id ?? 1,
            'pangkat_id' => $pangkatPembinaUtama->id ?? 1,
            'jabatan_id' => $jabatanStaffAdmin->id ?? 1,
        ]);

        // Data Pegawai - Budi Santoso
        Pegawai::create([
            'id' => '197501012000031001',
            'nama_lengkap' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1975-01-01',
            'gol_darah' => 'B',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS',
            'agama_id' => $agamaIslam->id ?? 1,
            'pangkat_id' => $pangkatPembinaUtamaMadya->id ?? 1,
            'jabatan_id' => $jabatanKepalaDinas->id ?? 1,
        ]);

        // Data Pegawai - Siti Aminah
        Pegawai::create([
            'id' => '198001152000032002',
            'nama_lengkap' => 'Siti Aminah',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Medan',
            'tanggal_lahir' => '1980-01-15',
            'gol_darah' => 'AB',
            'status_kawin' => 'M',
            'status_pegawai' => 'PNS',
            'agama_id' => $agamaIslam->id ?? 1,
            'pangkat_id' => $pangkatPembinaUntamaMuda->id ?? 1,
            'jabatan_id' => $jabatanStaffAdmin->id ?? 1,
        ]);

        // Data Pegawai - Hendra Wijaya
        Pegawai::create([
            'id' => '199001202000033003',
            'nama_lengkap' => 'Hendra Wijaya',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '1990-01-20',
            'gol_darah' => 'O',
            'status_kawin' => 'BM',
            'status_pegawai' => 'PPPK',
            'agama_id' => $agamaIslam->id ?? 1,
            'pangkat_id' => $pangkatPembinaUntamaMuda->id ?? 1,
            'jabatan_id' => $jabatanPerawatAhliMuda->id ?? 1,
        ]);
    }
}
