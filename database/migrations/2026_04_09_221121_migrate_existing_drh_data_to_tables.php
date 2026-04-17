<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $pegawaiRows = DB::table('pegawai')->select('id', 'riwayat_diklat', 'riwayat_jabatan', 'riwayat_penghargaan', 'riwayat_sertifikasi')->get();

        foreach ($pegawaiRows as $pegawai) {
            // Migrate diklat
            $diklat = json_decode($pegawai->riwayat_diklat, true);
            if (!empty($diklat) && is_array($diklat)) {
                DB::table('riwayat_diklats')->where('pegawai_id', $pegawai->id)->delete();
                foreach ($diklat as $d) {
                    if (empty($d['nama_diklat'])) continue;
                    DB::table('riwayat_diklats')->insert([
                        'pegawai_id' => $pegawai->id,
                        'nama_diklat' => $d['nama_diklat'],
                        'penyelenggara' => $d['penyelenggara'] ?? null,
                        'no_sertifikat' => $d['no_sertifikat'] ?? null,
                        'tahun' => $d['tahun'] ?? null,
                        'dokumen' => $d['dokumen'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Migrate jabatan
            $jabatan = json_decode($pegawai->riwayat_jabatan, true);
            if (!empty($jabatan) && is_array($jabatan)) {
                DB::table('riwayat_jabatans')->where('pegawai_id', $pegawai->id)->delete();
                foreach ($jabatan as $j) {
                    if (empty($j['pangkat_id']) || empty($j['unit_kerja_id'])) continue;
                    DB::table('riwayat_jabatans')->insert([
                        'pegawai_id' => $pegawai->id,
                        'pangkat_id' => $j['pangkat_id'],
                        'unit_kerja_id' => $j['unit_kerja_id'],
                        'tmt' => $j['tmt'] ?? null,
                        'no_sk' => $j['no_sk'] ?? null,
                        'dokumen' => $j['dokumen'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Migrate penghargaan
            $penghargaan = json_decode($pegawai->riwayat_penghargaan, true);
            if (!empty($penghargaan) && is_array($penghargaan)) {
                DB::table('penghargaans')->where('pegawai_id', $pegawai->id)->delete();
                foreach ($penghargaan as $p) {
                    if (empty($p['nama_penghargaan'])) continue;
                    DB::table('penghargaans')->insert([
                        'pegawai_id' => $pegawai->id,
                        'nama_penghargaan' => $p['nama_penghargaan'],
                        'tahun' => $p['tahun'] ?? null,
                        'instansi_pemberi' => $p['instansi_pemberi'] ?? null,
                        'dokumen' => $p['dokumen'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Migrate sertifikasi
            $sertifikasi = json_decode($pegawai->riwayat_sertifikasi, true);
            if (!empty($sertifikasi) && is_array($sertifikasi)) {
                DB::table('sertifikasis')->where('pegawai_id', $pegawai->id)->delete();
                foreach ($sertifikasi as $s) {
                    if (empty($s['nama_sertifikasi'])) continue;
                    DB::table('sertifikasis')->insert([
                        'pegawai_id' => $pegawai->id,
                        'nama_sertifikasi' => $s['nama_sertifikasi'],
                        'tahun' => $s['tahun'] ?? null,
                        'lembaga_pelaksana' => $s['lembaga_pelaksana'] ?? null,
                        'dokumen' => $s['dokumen'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
