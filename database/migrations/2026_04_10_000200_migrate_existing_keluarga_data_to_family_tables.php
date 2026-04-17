<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $pegawaiRows = DB::table('pegawai')->select('id', 'data_keluarga')->get();

        foreach ($pegawaiRows as $pegawai) {
            $keluarga = json_decode($pegawai->data_keluarga, true);
            if (empty($keluarga) || !is_array($keluarga)) {
                continue;
            }

            DB::table('pasangans')->where('pegawai_id', $pegawai->id)->delete();
            DB::table('anaks')->where('pegawai_id', $pegawai->id)->delete();
            DB::table('orang_tuas')->where('pegawai_id', $pegawai->id)->delete();
            DB::table('mertuas')->where('pegawai_id', $pegawai->id)->delete();
            DB::table('saudaras')->where('pegawai_id', $pegawai->id)->delete();

            if (!empty($keluarga['pasangan']['nama'])) {
                DB::table('pasangans')->insert([
                    'pegawai_id' => $pegawai->id,
                    'nik' => $keluarga['pasangan']['nik'] ?? null,
                    'nama' => $keluarga['pasangan']['nama'],
                    'status' => $keluarga['pasangan']['status'] ?? null,
                    'status_hidup' => $keluarga['pasangan']['status_hidup'] ?? null,
                    'tempat_lahir' => $keluarga['pasangan']['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $keluarga['pasangan']['tanggal_lahir'] ?? null,
                    'pekerjaan' => $keluarga['pasangan']['pekerjaan'] ?? null,
                    'file' => $keluarga['pasangan']['file'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!empty($keluarga['anak']) && is_array($keluarga['anak'])) {
                foreach ($keluarga['anak'] as $anak) {
                    if (empty($anak['nama'])) {
                        continue;
                    }

                    DB::table('anaks')->insert([
                        'pegawai_id' => $pegawai->id,
                        'nik' => $anak['nik'] ?? null,
                        'nama' => $anak['nama'],
                        'jenis_kelamin' => $anak['jenis_kelamin'] ?? null,
                        'tempat_lahir' => $anak['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $anak['tanggal_lahir'] ?? null,
                        'pekerjaan' => $anak['pekerjaan'] ?? null,
                        'status_anak' => $anak['status_anak'] ?? null,
                        'status_kawin' => $anak['status_kawin'] ?? null,
                        'file' => $anak['file'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if (!empty($keluarga['orang_tua']['ayah']['nama'])) {
                DB::table('orang_tuas')->insert([
                    'pegawai_id' => $pegawai->id,
                    'nik' => $keluarga['orang_tua']['ayah']['nik'] ?? null,
                    'nama' => $keluarga['orang_tua']['ayah']['nama'],
                    'alamat' => $keluarga['orang_tua']['ayah']['alamat'] ?? null,
                    'tempat_lahir' => null,
                    'tanggal_lahir' => $keluarga['orang_tua']['ayah']['tanggal_lahir'] ?? null,
                    'pekerjaan' => $keluarga['orang_tua']['ayah']['pekerjaan'] ?? null,
                    'status_hub' => 'Ayah',
                    'status_hidup' => $keluarga['orang_tua']['ayah']['status_hidup'] ?? null,
                    'file' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!empty($keluarga['orang_tua']['ibu']['nama'])) {
                DB::table('orang_tuas')->insert([
                    'pegawai_id' => $pegawai->id,
                    'nik' => $keluarga['orang_tua']['ibu']['nik'] ?? null,
                    'nama' => $keluarga['orang_tua']['ibu']['nama'],
                    'alamat' => $keluarga['orang_tua']['ibu']['alamat'] ?? null,
                    'tempat_lahir' => null,
                    'tanggal_lahir' => $keluarga['orang_tua']['ibu']['tanggal_lahir'] ?? null,
                    'pekerjaan' => $keluarga['orang_tua']['ibu']['pekerjaan'] ?? null,
                    'status_hub' => 'Ibu',
                    'status_hidup' => $keluarga['orang_tua']['ibu']['status_hidup'] ?? null,
                    'file' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!empty($keluarga['saudara']) && is_array($keluarga['saudara'])) {
                foreach ($keluarga['saudara'] as $sdr) {
                    if (empty($sdr['nama'])) {
                        continue;
                    }

                    DB::table('saudaras')->insert([
                        'pegawai_id' => $pegawai->id,
                        'nik' => $sdr['nik'] ?? null,
                        'nama' => $sdr['nama'],
                        'jenis_kelamin' => $sdr['jenis_kelamin'] ?? null,
                        'tanggal_lahir' => $sdr['tanggal_lahir'] ?? null,
                        'pekerjaan' => $sdr['pekerjaan'] ?? null,
                        'status_hub' => $sdr['status_saudara'] ?? null,
                        'status_kawin' => $sdr['status_kawin'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            if (!empty($keluarga['mertua']['ayah']['nama'])) {
                DB::table('mertuas')->insert([
                    'pegawai_id' => $pegawai->id,
                    'nik' => $keluarga['mertua']['ayah']['nik'] ?? null,
                    'nama' => $keluarga['mertua']['ayah']['nama'],
                    'tempat_lahir' => null,
                    'tanggal_lahir' => $keluarga['mertua']['ayah']['tanggal_lahir'] ?? null,
                    'pekerjaan' => $keluarga['mertua']['ayah']['pekerjaan'] ?? null,
                    'status_hub' => 'Ayah Mertua',
                    'status_hidup' => $keluarga['mertua']['ayah']['status_hidup'] ?? null,
                    'file' => $keluarga['mertua']['ayah']['file'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!empty($keluarga['mertua']['ibu']['nama'])) {
                DB::table('mertuas')->insert([
                    'pegawai_id' => $pegawai->id,
                    'nik' => $keluarga['mertua']['ibu']['nik'] ?? null,
                    'nama' => $keluarga['mertua']['ibu']['nama'],
                    'tempat_lahir' => null,
                    'tanggal_lahir' => $keluarga['mertua']['ibu']['tanggal_lahir'] ?? null,
                    'pekerjaan' => $keluarga['mertua']['ibu']['pekerjaan'] ?? null,
                    'status_hub' => 'Ibu Mertua',
                    'status_hidup' => $keluarga['mertua']['ibu']['status_hidup'] ?? null,
                    'file' => $keluarga['mertua']['ibu']['file'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // This migration only migrates existing JSON into relational tables.
    }
};
