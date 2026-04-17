<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExternalApiController;
use App\Http\Controllers\MasterUnitKerjaController;

// API Route untuk cek NIP
Route::get('/api/cek-nip/{nip}', [ExternalApiController::class, 'getPegawaiByNip'])->name('cek-nip');

// API Route untuk cek NIK keluarga
Route::get('/api/cek-keluarga/{nik}', [\App\Http\Controllers\PegawaiController::class, 'cekKeluarga']);

// API Cascading Jabatan
Route::get('/api/jabatan/jenis', [JabatanController::class, 'getJenis']);
Route::get('/api/jabatan/eselon/{jenis}', [JabatanController::class, 'getEselon']);
Route::get('/api/jabatan/nama', [JabatanController::class, 'getNamaJabatan']);

// 1. Halaman awal: Cover Page
Route::get('/', function () { 
    return view('cover'); 
});

// 2. Auth Routes
Route::get('/login', function () { 
    return view('login'); 
});
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// 3. Dashboard Route (GANTI BAGIAN INI)
// Sekarang kita arahkan ke function 'dashboard' di AuthController
Route::get('/dashboard', [AuthController::class, 'dashboard']);
use App\Http\Controllers\PegawaiController;

// Halaman Daftar Pegawai (DUK)
Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::get('/admin/duk', [PegawaiController::class, 'adminDuk']);

// Aksi simpan pegawai baru
Route::post('/pegawai/store', [PegawaiController::class, 'store']);
Route::post('/pegawai/{id}/reset-password', [PegawaiController::class, 'resetPassword']);
Route::post('/pegawai/{id}/toggle-status', [PegawaiController::class, 'toggleStatus']);

// Superadmin: Tambah Admin
Route::get('/superadmin/tambah-admin', [PegawaiController::class, 'tambahAdmin']);
Route::post('/superadmin/store-admin', [PegawaiController::class, 'storeAdmin']);

// Superadmin: Kelola Admin
Route::get('/superadmin/kelola-admin', [PegawaiController::class, 'kelolaAdmin']);
Route::post('/superadmin/admin/{id}/ubah-password', [PegawaiController::class, 'ubahPasswordAdmin']);
Route::delete('/superadmin/admin/{id}/hapus', [PegawaiController::class, 'hapusAdmin']);

// API Lookup NIP dari SPLP
Route::get('/api/pegawai/lookup/{nip}', [PegawaiController::class, 'lookupNip']);

// Aksi update password pegawai
Route::post('/pegawai/update-password', [App\Http\Controllers\PegawaiController::class, 'updatePassword']);
Route::post('/pegawai/{id}/ubah-password', [PegawaiController::class, 'ubahPassword']);

// Halaman Profile Pegawai
Route::get('/profile', [PegawaiController::class, 'profile']);
Route::post('/profile/update-profil', [PegawaiController::class, 'updateProfileBasic']);
Route::post('/profile/upload-foto', [PegawaiController::class, 'uploadFotoProfil']);
Route::get('/profile/drh', [PegawaiController::class, 'drh']);
Route::get('/profile/drh/identitas', [PegawaiController::class, 'drhIdentitas']);
Route::post('/profile/drh', [PegawaiController::class, 'storeDrh']);
Route::get('/profile/drh/file/{type}/view', [PegawaiController::class, 'viewDrhFile']);
Route::get('/profile/drh/file/{type}/download', [PegawaiController::class, 'downloadDrhFile']);
Route::delete('/profile/drh/file/{type}/delete', [PegawaiController::class, 'deleteDrhFile']);
Route::delete('/profile/drh/dokumen/{section}/{id}/delete-file', [PegawaiController::class, 'deleteDrhDocumentFile']);
Route::delete('/profile/drh/pendidikan/{id}/delete-file', [PegawaiController::class, 'deletePendidikanFile']);

// --- API Hapus Riwayat DRH ---
Route::delete('/profile/drh/pendidikan/{id}', [PegawaiController::class, 'deleteRiwayatPendidikan']);
Route::delete('/profile/drh/diklat/{id}', [PegawaiController::class, 'deleteRiwayatDiklat']);
Route::delete('/profile/drh/jabatan/{id}', [PegawaiController::class, 'deleteRiwayatJabatan']);
Route::delete('/profile/drh/penghargaan/{id}', [PegawaiController::class, 'deleteRiwayatPenghargaan']);
Route::delete('/profile/drh/sertifikasi/{id}', [PegawaiController::class, 'deleteRiwayatSertifikasi']);

// Arsip Dokumen Pegawai
Route::get('/pegawai/riwayat-hidup', [PegawaiController::class, 'riwayatHidup']);
Route::get('/pegawai/riwayat-hidup/print', [PegawaiController::class, 'pegawaiPrintDrh']);
Route::get('/pegawai/arsip', [PegawaiController::class, 'arsip']);
Route::post('/pegawai/arsip/upload', [PegawaiController::class, 'uploadDocument']);
Route::get('/pegawai/arsip/download/{id}', [PegawaiController::class, 'downloadDocument']);
Route::get('/pegawai/arsip/view/{id}', [PegawaiController::class, 'viewDocument']);
Route::delete('/pegawai/arsip/delete/{id}', [PegawaiController::class, 'deleteDocument']);

// Admin Validasi Dokumen
Route::get('/admin/validasi-dokumen', [PegawaiController::class, 'adminValidasiDokumen']);
Route::post('/admin/validasi-dokumen/{id}/approve', [PegawaiController::class, 'approveDocument'])->name('admin.document.approve');
Route::post('/admin/validasi-dokumen/{id}/reject', [PegawaiController::class, 'rejectDocument'])->name('admin.document.reject');

// Admin Pegawai DRH
Route::get('/admin/pegawai/{id}/drh', [PegawaiController::class, 'adminViewPegawaiDrh']);
Route::get('/admin/pegawai/{id}/drh/print', [PegawaiController::class, 'adminPrintPegawaiDrh']);
Route::get('/admin/pegawai/{id}/arsip', [PegawaiController::class, 'adminKelolaArsipPegawai']);
Route::get('/admin/pegawai/arsip/dokumen/{id}/view', [PegawaiController::class, 'adminViewArsipDocument']);
Route::get('/admin/pegawai/arsip/dokumen/{id}/download', [PegawaiController::class, 'adminDownloadArsipDocument']);
Route::get('/admin/drh/legal/{userId}/{type}/view', [PegawaiController::class, 'adminViewLegalDoc']);
Route::get('/admin/drh/legal/{userId}/{type}/download', [PegawaiController::class, 'adminDownloadLegalDoc']);
Route::get('/admin/drh/legal/{userId}/{type}/print', [PegawaiController::class, 'adminPrintLegalDoc']);

// Pengajuan Berkas
Route::get('/pengajuan-berkas', [PegawaiController::class, 'pengajuanBerkas']);

// User Activity Logs
Route::get('/admin/user-activity', [\App\Http\Controllers\UserActivityController::class, 'adminActivityLogs'])->name('admin.user-activity');
Route::get('/superadmin/user-activity', [\App\Http\Controllers\UserActivityController::class, 'superadminActivityLogs'])->name('superadmin.user-activity');

// Test Telegram (debug route - hapus setelah testing)
Route::get('/test-telegram', function () {
    $pesan = "🧪 *Test Pesan Telegram*\n\n";
    $pesan .= "Waktu: " . date('d-m-Y H:i:s') . "\n";
    $pesan .= "Status: Pesan test berhasil terkirim!";
    
    $result = \App\Helpers\TelegramHelper::kirimTelegram($pesan);
    
    return response()->json([
        'status' => $result ? 'success' : 'failed',
        'message' => $result ? 'Pesan berhasil dikirim ke Telegram' : 'Gagal mengirim pesan'
    ]);
});

// Master Data Management
Route::prefix('admin/master')->group(function () {
    Route::get('/agama', [\App\Http\Controllers\MasterAgamaController::class, 'index']);
    Route::post('/agama', [\App\Http\Controllers\MasterAgamaController::class, 'store']);
    Route::put('/agama/{id}', [\App\Http\Controllers\MasterAgamaController::class, 'update']);
    Route::delete('/agama/{id}', [\App\Http\Controllers\MasterAgamaController::class, 'destroy']);

    Route::get('/pendidikan', [\App\Http\Controllers\MasterPendidikanController::class, 'index']);
    Route::post('/pendidikan', [\App\Http\Controllers\MasterPendidikanController::class, 'store']);
    Route::put('/pendidikan/{id}', [\App\Http\Controllers\MasterPendidikanController::class, 'update']);
    Route::delete('/pendidikan/{id}', [\App\Http\Controllers\MasterPendidikanController::class, 'destroy']);

    Route::get('/arsip', [\App\Http\Controllers\MasterArsipController::class, 'index']);
    Route::post('/arsip', [\App\Http\Controllers\MasterArsipController::class, 'store']);
    Route::put('/arsip/{id}', [\App\Http\Controllers\MasterArsipController::class, 'update']);
    Route::delete('/arsip/{id}', [\App\Http\Controllers\MasterArsipController::class, 'destroy']);

    Route::get('/jabatan', [\App\Http\Controllers\MasterJabatanController::class, 'index']);
    Route::post('/jabatan', [\App\Http\Controllers\MasterJabatanController::class, 'store']);
    Route::put('/jabatan/{id}', [\App\Http\Controllers\MasterJabatanController::class, 'update']);
    Route::delete('/jabatan/{id}', [\App\Http\Controllers\MasterJabatanController::class, 'destroy']);

    Route::get('/pangkat', [\App\Http\Controllers\MasterPangkatController::class, 'index']);
    Route::post('/pangkat', [\App\Http\Controllers\MasterPangkatController::class, 'store']);
    Route::put('/pangkat/{id}', [\App\Http\Controllers\MasterPangkatController::class, 'update']);
    Route::delete('/pangkat/{id}', [\App\Http\Controllers\MasterPangkatController::class, 'destroy']);

    Route::get('/penghargaan', [\App\Http\Controllers\MasterPenghargaanController::class, 'index']);
    Route::post('/penghargaan', [\App\Http\Controllers\MasterPenghargaanController::class, 'store']);
    Route::delete('/penghargaan/{id}', [\App\Http\Controllers\MasterPenghargaanController::class, 'destroy']);

    Route::get('/sertifikasi', [\App\Http\Controllers\MasterSertifikasiController::class, 'index']);
    Route::post('/sertifikasi', [\App\Http\Controllers\MasterSertifikasiController::class, 'store']);
    Route::delete('/sertifikasi/{id}', [\App\Http\Controllers\MasterSertifikasiController::class, 'destroy']);

    Route::get('/diklat', [\App\Http\Controllers\MasterDiklatController::class, 'index']);
});

// Master Data Unit Kerja
Route::get('/master/unitkerja', [MasterUnitKerjaController::class, 'index']);
Route::post('/master/unitkerja', [MasterUnitKerjaController::class, 'store']);
Route::put('/master/unitkerja/{id}', [MasterUnitKerjaController::class, 'update']);
Route::delete('/master/unitkerja/{id}', [MasterUnitKerjaController::class, 'destroy']);
Route::get('/master/unitkerja/{id}/asn', [MasterUnitKerjaController::class, 'asnList']);

// Hapus file dokumen pendidikan saja
Route::delete('/pegawai/pendidikan/{id}/dokumen', [\App\Http\Controllers\PegawaiController::class, 'deletePendidikanFile'])->name('pegawai.pendidikan.deleteFile');

// Hapus file dokumen diklat saja
Route::delete('/pegawai/diklat/{id}/dokumen', [\App\Http\Controllers\PegawaiController::class, 'deleteDiklatFile'])->name('pegawai.diklat.deleteFile');

// Hapus file dokumen jabatan saja
Route::delete('/pegawai/jabatan/{id}/dokumen', [\App\Http\Controllers\PegawaiController::class, 'deleteJabatanFile'])->name('pegawai.jabatan.deleteFile');

// Hapus file dokumen penghargaan saja
Route::delete('/pegawai/penghargaan/{id}/dokumen', [\App\Http\Controllers\PegawaiController::class, 'deletePenghargaanFile'])->name('pegawai.penghargaan.deleteFile');

// Hapus file dokumen sertifikasi saja
Route::delete('/pegawai/sertifikasi/{id}/dokumen', [\App\Http\Controllers\PegawaiController::class, 'deleteSertifikasiFile'])->name('pegawai.sertifikasi.deleteFile');

// Hapus file dokumen unit kerja saja
Route::delete('/pegawai/unit-kerja/{id}/dokumen', [\App\Http\Controllers\PegawaiController::class, 'deleteUnitKerjaFile'])->name('pegawai.unit-kerja.deleteFile');
