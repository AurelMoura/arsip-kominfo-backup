<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Document;
use App\Models\Agama;
use App\Models\Pangkat;
use App\Models\Jabatan;
use App\Models\Eselon;
use App\Models\Pasangan;
use App\Models\Anak;
use App\Models\OrangTua;
use App\Models\Mertua;
use App\Models\Saudara;
use App\Models\Pendidikan;
use App\Models\RiwayatPendidikan;
use App\Models\RiwayatDiklat;
use App\Models\RiwayatJabatan;
use App\Models\Penghargaan;
use App\Models\Sertifikasi;
use App\Models\UnitKerja;
use App\Models\IdentitasLegal;
use App\Helpers\TelegramHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\PegawaiRepositoryInterface;

class PegawaiController extends Controller
{
    public function __construct(
        protected PegawaiRepositoryInterface $pegawaiRepository
    ) {}
    /**
     * Menampilkan Daftar Pegawai (Hanya untuk Role Admin)
     */
    public function index()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $pegawai = User::where('role', 'pegawai')->with('pegawai')->get();
        $total_pegawai = $pegawai->count();

        return view('dashboard.pegawai_duk', compact('pegawai', 'total_pegawai'));
    }

    /**
     * Lookup NIP via SPLP API
     */
    public function lookupNip($nip)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $data = $this->pegawaiRepository->findByNip($nip);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'nama_lengkap' => $data['nama_lengkap'],
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Data pegawai tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghubungi server API'], 500);
        }
    }

    /**
     * Cek NIK keluarga di tabel pegawai (kolom no_nik)
     */
    public function cekKeluarga($nik)
    {
        if (!Session::has('role')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $nik = trim($nik);

        $pegawai = Pegawai::where('no_nik', $nik)->first();

        if ($pegawai) {
            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $pegawai->nama_lengkap,
                    'tempat_lahir' => $pegawai->tempat_lahir,
                    'tanggal_lahir' => $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('Y-m-d') : null,
                    'jenis_kelamin' => $pegawai->jenis_kelamin,
                    'pekerjaan' => null,
                    'alamat' => null,
                ],
            ]);
        }

        return response()->json(['success' => false, 'message' => 'NIK tidak ditemukan'], 404);
    }

    /**
     * Halaman Tambah Admin (Hanya Superadmin)
     */
    public function tambahAdmin()
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        return view('dashboard.superadmin_tambah_admin');
    }

    /**
     * Simpan Admin Baru (Hanya Superadmin)
     */
    public function storeAdmin(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        $validator = Validator::make($request->all(), [
            'nip' => 'required|digits:18|unique:users,pegawai_id',
            'nama_lengkap' => 'required|string|max:100',
            'password' => 'required|min:6|confirmed',
        ], [
            'nip.digits' => 'NIP harus tepat 18 digit.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'pegawai_id' => $request->nip,
            'name' => $request->nama_lengkap,
            'role' => 'admin',
            'password' => Hash::make($request->password),
            'is_first_login' => false,
        ]);

        return redirect('/superadmin/tambah-admin')->with('success', 'Akun admin baru berhasil dibuat.');
    }

    /**
     * Superadmin: Lihat semua admin
     */
    public function kelolaAdmin()
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        $admins = User::whereIn('role', ['admin', 'superadmin'])->orderByRaw("FIELD(role, 'superadmin', 'admin')")->get();

        return view('dashboard.superadmin_kelola_admin', compact('admins'));
    }

    /**
     * Superadmin: Ubah password admin
     */
    public function ubahPasswordAdmin(Request $request, $id)
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $admin = User::where('id', $id)->where('role', 'admin')->firstOrFail();
        $admin->update([
            'password' => Hash::make($request->password),
            'last_password_change' => now(),
        ]);

        return redirect('/superadmin/kelola-admin')->with('success', 'Password admin '.$admin->name.' berhasil diubah.');
    }

    /**
     * Superadmin: Hapus admin
     */
    public function hapusAdmin($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return redirect('/login');
        }

        $admin = User::where('id', $id)->where('role', 'admin')->firstOrFail();
        $nama = $admin->name;
        $admin->delete();

        return redirect('/superadmin/kelola-admin')->with('success', 'Admin '.$nama.' berhasil dihapus.');
    }

    /**
     * Reset Password Pegawai ke NIP
     */
    public function resetPassword($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($user->pegawai_id),
            'is_first_login' => true,
            'last_password_change' => now(),
        ]);

        return redirect('/pegawai')->with('success', 'Password pegawai ' . $user->name . ' berhasil direset ke NIP.');
    }

    /**
     * Toggle Status Aktif/Nonaktif Pegawai
     */
    public function toggleStatus($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect('/pegawai')->with('success', 'Akun pegawai ' . $user->name . ' berhasil ' . $status . '.');
    }

    /**
     * Admin Menambahkan Pegawai Baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|digits:18|unique:users,pegawai_id',
            'nama_lengkap' => 'required',
        ], [
            'nip.digits' => 'NIP harus tepat 18 digit.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Password default adalah NIP pegawai
        $defaultPassword = (string) $request->nip;

        User::create([
            'pegawai_id' => $request->nip,
            'name' => $request->nama_lengkap,
            'role' => 'pegawai',
            'password' => Hash::make($defaultPassword),
            'is_first_login' => true // Ditandai agar pegawai wajib mengubah password saat login pertama
        ]);

        return redirect('/pegawai')->with('success', 'Pegawai berhasil ditambahkan! Password default: NIP pegawai. Pegawai wajib mengubah password saat login pertama.');
    }

    /**
     * Menampilkan Halaman Kelola Profil Pegawai
     */
    public function profile()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Ambil data Pegawai berdasarkan pegawai_id/NIP dengan relationships
        $pegawaiData = Pegawai::with(['unit_kerja'])
            ->where('id', Session::get('identifier'))
            ->first();

        return view('dashboard.profile', compact('pegawaiData'));
    }

    /**
     * Update Profil Kontak (Email, No HP)
     */
    public function updateProfileBasic(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Validasi
        $validated = $request->validate([
            'email' => 'required|email',
            'no_hp' => 'required|regex:/^08[0-9]{7,11}$/',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'gol_darah' => 'required|in:A,B,AB,O',
            'status_kawin' => 'required|in:M,BM,CH,CM',
            'status_pegawai' => 'required|in:PNS,PPPK',
            'no_nik' => 'required|string'
        ]);

        try {
            $pegawai = Pegawai::firstOrNew(['id' => Session::get('identifier')]);

            $pegawai->nama_lengkap = $validated['nama_lengkap'];
            $pegawai->jenis_kelamin = $validated['jenis_kelamin'];
            $pegawai->tempat_lahir = $validated['tempat_lahir'];
            $pegawai->tanggal_lahir = $validated['tanggal_lahir'];
            $pegawai->gol_darah = $validated['gol_darah'];
            $pegawai->status_kawin = $validated['status_kawin'];
            $pegawai->status_pegawai = $validated['status_pegawai'];
            $pegawai->no_nik = $validated['no_nik'];
            $pegawai->email = $validated['email'];
            $pegawai->no_hp = $validated['no_hp'];
            $pegawai->save();

            // Update nama pada tabel users jika perlu
            $user = User::find(Session::get('user_id'));
            if ($user) {
                $user->name = $validated['nama_lengkap'];
                $user->save();
                Session::put('name', $validated['nama_lengkap']);
            }

            return redirect('/profile')->with('success', 'Data profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect('/profile')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Upload Foto Profil Pegawai
     */
    public function uploadFotoProfil(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto_profil.required' => 'Foto profil wajib diunggah.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'foto_profil.max' => 'Ukuran maksimal foto adalah 2 MB.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->errors()->first('foto_profil')
            ], 422);
        }

        try {
            $pegawai = Pegawai::find(Session::get('identifier'));

            if (!$pegawai) {
                return response()->json(['success' => false, 'message' => 'Silakan lengkapi Profil Dasar terlebih dahulu sebelum mengupload foto.'], 422);
            }

            // Hapus foto lama jika ada
            if ($pegawai->foto_profil && Storage::disk('public')->exists($pegawai->foto_profil)) {
                Storage::disk('public')->delete($pegawai->foto_profil);
            }

            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $pegawai->foto_profil = $path;
            $pegawai->save();

            return response()->json([
                'success' => true,
                'url' => Storage::disk('public')->url($path),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan Halaman Daftar Riwayat Hidup (Read-Only View) untuk Pegawai
     */
    public function riwayatHidup()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        if (Session::get('is_first_login')) {
            return redirect('/dashboard')->with('error', 'Anda wajib mengganti password terlebih dahulu.');
        }

        $user = User::where('pegawai_id', Session::get('identifier'))->first();
        if (!$user) {
            return redirect('/dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $drhData = $this->buildAdminDrhData($user);
        $isAdmin = false;

        return view('dashboard.admin_pegawai_drh', compact('user', 'drhData', 'isAdmin'));
    }

    /**
     * Menampilkan Halaman Daftar Riwayat Hidup (DRH) Pegawai
     */
    public function drh()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Wajib ganti password dulu sebelum akses DRH
        if (Session::get('is_first_login')) {
            return redirect('/dashboard')->with('error', 'Anda wajib mengganti password terlebih dahulu sebelum mengakses Daftar Riwayat Hidup.');
        }

        $drhData = Pegawai::with([
            'riwayatPendidikans.pendidikan',
            'riwayatDiklats',
            'riwayatJabatans.unit_kerja',
            'riwayatJabatans.pangkat',
            'riwayatJabatans.jabatan',
            'riwayatJabatans.eselon',
            'penghargaans',
            'sertifikasis',
            'unit_kerja',
        ])->where('id', Session::get('identifier'))->first();
        
        // Ambil status profil dasar lengkap dari users table
        $profilDasarLengkap = User::where('pegawai_id', Session::get('identifier'))->value('profil_dasar_lengkap') ?? false;
        
        // Ambil data dari database untuk dropdown
        $agamaList = Agama::where('aktif', 'Y')->orderBy('nama')->get();
        $pangkatList = Pangkat::where('aktif', 'Y')->orderBy('golongan')->get();
        $jabatanList = Jabatan::where('aktif', 'Y')->orderBy('nama_jabatan')->get();
        // Ambil eselon dari tabel eselons
        $eselonList = Eselon::where('aktif', 'Y')->orderBy('nama')->get();
        $pendidikanList = Pendidikan::where('aktif', 'Y')->orderBy('nama')->get();
        $unitKerjaList = UnitKerja::orderBy('name')->get();
        $masterPenghargaanList = \App\Models\MasterPenghargaan::orderBy('nama_penghargaan')->get();
        $masterSertifikasiList = \App\Models\MasterSertifikasi::orderBy('nama_sertifikasi')->get();

        $pendidikanRows = [];
        if ($drhData) {
            $pendidikanRows = $drhData->riwayatPendidikans->map(function ($item) {
                return [
                    'id' => $item->id,
                    'pendidikan_id' => $item->pendidikan_id,
                    'jenjang' => $item->pendidikan?->nama,
                    'nama_sekolah' => $item->nama_instansi,
                    'tahun_masuk' => $item->tahun_masuk,
                    'tahun_lulus' => $item->tahun_keluar,
                    'nomor_ijazah' => $item->no_ijazah,
                    'nama_pejabat' => $item->nama_pejabat,
                    'file' => $item->dokumen,
                ];
            })->toArray();

            $drhData->riwayat_diklat = $drhData->riwayatDiklats->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama_diklat,
                    'penyelenggara' => $item->penyelenggara,
                    'nomor_sertifikat' => $item->no_sertifikat,
                    'tahun' => $item->tahun,
                    'file' => $item->dokumen,
                ];
            })->toArray();

            $drhData->riwayat_jabatan = $drhData->riwayatJabatans->map(function ($item) {
                return [
                    'id' => $item->id,
                    'jenis_jabatan' => $item->jenis_jabatan,
                    'jabatan' => $item->nama_jabatan,
                    'nama_jabatan' => $item->nama_jabatan,
                    'eselon' => $item->eselon,
                    'unit_kerja' => $item->unit_kerja?->name ?? '-',
                    'golongan' => $item->pangkat?->golongan ?? '-',
                    'no_sk' => $item->no_sk,
                    'tmt' => $item->tmt,
                    'file' => $item->dokumen,
                ];
            })->toArray();

            $drhData->riwayat_penghargaan = $drhData->penghargaans->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama_penghargaan,
                    'tahun' => $item->tahun,
                    'instansi' => $item->instansi_pemberi,
                    'file' => $item->dokumen,
                ];
            })->toArray();

            $drhData->riwayat_sertifikasi = $drhData->sertifikasis->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama_sertifikasi,
                    'tahun' => $item->tahun,
                    'lembaga' => $item->lembaga_pelaksana,
                    'file' => $item->dokumen,
                ];
            })->toArray();

            $identitasLegal = IdentitasLegal::where('pegawai_id', $drhData->id)->first();
            $drhData->identitas_legal = [
                'nik_ktp' => $identitasLegal?->no_ktp,
                'nomor_npwp' => $identitasLegal?->no_npwp,
                'nomor_bpjs' => $identitasLegal?->no_bpjs,
                'file_ktp' => $identitasLegal?->dok_ktp,
                'file_npwp' => $identitasLegal?->dok_npwp,
                'file_bpjs' => $identitasLegal?->dok_bpjs,
                'file_kk' => $identitasLegal?->dok_kk,
            ];
        }

        return view('dashboard.drh', compact('drhData', 'profilDasarLengkap', 'agamaList', 'pangkatList', 'jabatanList', 'eselonList', 'unitKerjaList', 'pendidikanList', 'pendidikanRows', 'masterPenghargaanList', 'masterSertifikasiList'));
    }

    /**
     * Menampilkan halaman khusus Identitas Legal DRH
     */
    public function drhIdentitas()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $drhData = Pegawai::where('id', Session::get('identifier'))->first();

        if ($drhData) {
            $identitasLegal = IdentitasLegal::where('pegawai_id', $drhData->id)->first();
            $drhData->identitas_legal = [
                'nik_ktp' => $identitasLegal?->no_ktp,
                'nomor_npwp' => $identitasLegal?->no_npwp,
                'nomor_bpjs' => $identitasLegal?->no_bpjs,
                'file_ktp' => $identitasLegal?->dok_ktp,
                'file_npwp' => $identitasLegal?->dok_npwp,
                'file_bpjs' => $identitasLegal?->dok_bpjs,
                'file_kk' => $identitasLegal?->dok_kk,
            ];
        }

        return view('dashboard.drh.identitas', compact('drhData'));
    }

    /**
     * Pegawai: View DRH file PDF inline
     */
    public function viewDrhFile($type)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $pegawaiId = Session::get('identifier');
        $identitas = IdentitasLegal::where('pegawai_id', $pegawaiId)->first();

        if (!$identitas) {
            return back()->with('error', 'Data identitas legal tidak ditemukan.');
        }

        $fileMap = [
            'ktp' => $identitas->dok_ktp,
            'npwp' => $identitas->dok_npwp,
            'bpjs' => $identitas->dok_bpjs,
            'kk' => $identitas->dok_kk,
        ];

        $filePath = $fileMap[$type] ?? null;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File dokumen tidak ditemukan.');
        }

        return response()->file(Storage::disk('public')->path($filePath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    /**
     * Pegawai: Download DRH file
     */
    public function downloadDrhFile($type)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $pegawaiId = Session::get('identifier');
        $identitas = IdentitasLegal::where('pegawai_id', $pegawaiId)->first();

        if (!$identitas) {
            return back()->with('error', 'Data identitas legal tidak ditemukan.');
        }

        $fileMap = [
            'ktp' => $identitas->dok_ktp,
            'npwp' => $identitas->dok_npwp,
            'bpjs' => $identitas->dok_bpjs,
            'kk' => $identitas->dok_kk,
        ];

        $filePath = $fileMap[$type] ?? null;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->download($filePath, basename($filePath));
    }

    /**
     * Pegawai: Hapus file DRH (identitas legal)
     */
    public function deleteDrhFile($type)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $pegawaiId = Session::get('identifier');
        $identitas = IdentitasLegal::where('pegawai_id', $pegawaiId)->first();

        if (!$identitas) {
            return back()->with('error', 'Data identitas legal tidak ditemukan.');
        }

        $columnMap = [
            'ktp' => 'dok_ktp',
            'npwp' => 'dok_npwp',
            'bpjs' => 'dok_bpjs',
            'kk' => 'dok_kk',
        ];

        $column = $columnMap[$type] ?? null;

        if (!$column || !$identitas->$column) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // Hapus file dari storage
        if (Storage::disk('public')->exists($identitas->$column)) {
            Storage::disk('public')->delete($identitas->$column);
        }

        // Null-kan kolom di database
        $identitas->update([$column => null]);

        return back()->with('success', 'Dokumen berhasil dihapus. Silakan upload ulang jika diperlukan.');
    }

    /**
     * Pegawai: Hapus file dokumen DRH (pendidikan, diklat, jabatan, sertifikasi, penghargaan)
     */
    public function deleteDrhDocumentFile($section, $id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $pegawaiId = Session::get('identifier');

        $modelMap = [
            'pendidikan' => RiwayatPendidikan::class,
            'diklat' => RiwayatDiklat::class,
            'jabatan' => RiwayatJabatan::class,
            'sertifikasi' => Sertifikasi::class,
            'penghargaan' => Penghargaan::class,
        ];

        $modelClass = $modelMap[$section] ?? null;

        if (!$modelClass) {
            return back()->with('error', 'Jenis dokumen tidak valid.');
        }

        $record = $modelClass::where('id', $id)->where('pegawai_id', $pegawaiId)->first();

        if (!$record) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        if ($record->dokumen && Storage::disk('public')->exists($record->dokumen)) {
            Storage::disk('public')->delete($record->dokumen);
        }

        $record->update(['dokumen' => null]);

        return back()->with('success', 'Dokumen berhasil dihapus. Silakan upload ulang jika diperlukan.');
    }

    /**
     * Pegawai Memperbarui Password (Ganti Password Wajib Pertama Kali)
     * Setelah berhasil, status is_first_login jadi false agar modal tidak muncul lagi selamanya.
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input - Password harus memenuhi kriteria keamanan
        // Minimal 8 karakter dengan kombinasi: huruf besar, huruf kecil, angka, dan simbol
        $request->validate([
            'password_baru' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])/',
            'konfirmasi_password' => 'required|same:password_baru'
        ], [
            'password_baru.required' => 'Password baru harus diisi.',
            'password_baru.min' => 'Password minimal harus 8 karakter.',
            'password_baru.regex' => 'Password tidak memenuhi kriteria keamanan. Pastikan password memiliki minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.',
            'konfirmasi_password.required' => 'Konfirmasi password harus diisi.',
            'konfirmasi_password.same' => 'Konfirmasi password tidak cocok dengan password baru.'
        ]);

        // 2. Ambil user yang sedang login
        $user = User::find(Session::get('user_id'));

        if ($user) {
            // 3. Update Password dan Matikan Status Login Pertama
            $user->update([
                'password' => Hash::make($request->password_baru),
                'is_first_login' => false,
                'password_change_count' => ($user->password_change_count ?? 0) + 1,
                'last_password_change' => now(),
            ]);

            // 4. Update Session secara instan dan simpan ke server
            Session::put('is_first_login', false);
            Session::save(); // Memastikan session benar-benar berubah detik ini juga

            // 5. Lempar ke halaman A. PROFIL DASAR (Wajib Diisi)
            return redirect('/profile/drh')->with('success', 'Password telah diubah dengan sukses. Silakan lengkapi Profil Dasar.');
        }

        return back()->with('error', 'User tidak ditemukan.');
    }

    /**
     * Menyimpan Data Daftar Riwayat Hidup (DRH) Pegawai
     */
    public function storeDrh(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
            }
            return redirect('/login');
        }

        $step = $request->input('step', 0);

        try {
            // Validate that pegawai exists
            $pegawaiId = Session::get('identifier');
            if (!$pegawaiId) {
                if ($request->wantsJson()) {
                    return response()->json(['status' => 'error', 'message' => 'ID pegawai tidak ditemukan dalam session'], 422);
                }
                return redirect('/login');
            }
            
            $pegawai = Pegawai::firstOrNew(['id' => $pegawaiId]);

            switch ($step) {
                case 0: // Profil Dasar
                    $this->storeProfilDasar($request, $pegawai);
                    break;
                case 1: // Dokumen Keluarga
                    $this->storeDokumenKeluarga($request, $pegawai);
                    break;
                case 2: // Riwayat Pendidikan
                    $this->storeRiwayatPendidikan($request, $pegawai);
                    break;
                case 3: // Riwayat Diklat
                    $this->storeRiwayatDiklat($request, $pegawai);
                    break;
                case 4: // Riwayat Jabatan
                    $this->storeRiwayatJabatan($request, $pegawai);
                    break;
                case 5: // Riwayat Penghargaan
                    $this->storeRiwayatPenghargaan($request, $pegawai);
                    break;
                case 6: // Riwayat Sertifikasi
                    $this->storeRiwayatSertifikasi($request, $pegawai);
                    break;
                case 7: // Identitas Legal
                    $this->storeIdentitasLegal($request, $pegawai);
                    break;
                default:
                    if ($request->wantsJson()) {
                        return response()->json(['status' => 'error', 'message' => 'Step tidak valid.'], 422);
                    }
                    return redirect()->back()->withInput()->with('error', 'Step tidak valid.');
            }

            // Cek apakah semua data DRH sudah lengkap
            $this->checkDrhCompleteness($pegawai);

            $message = 'Data berhasil disimpan';
            
            // Return JSON response for AJAX requests
            if ($request->wantsJson()) {
                // Collect file paths for the saved section
                $filePaths = $this->collectFilePaths($step, $pegawai);
                
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'step' => $step,
                    'files' => $filePaths
                ]);
            }

            // Fallback redirect for form submission
            return redirect('/profile/drh')->with('success', 'Profil dasar berhasil disimpan. Sistem akan otomatis menuju ke bagian B: Data Keluarga.')->with('step', 1);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors properly for AJAX
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal. Periksa kembali data yang Anda isi.',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menyimpan Profil Dasar (Step 0)
     */
    private function storeProfilDasar(Request $request, Pegawai $pegawai)
    {
        // Get dynamic list dari database untuk validation
        $agamaList = Agama::where('aktif', 'Y')->pluck('nama')->toArray();
        $pangkatList = Pangkat::where('aktif', 'Y')->pluck('golongan')->toArray();
        $jabatanIdList = Jabatan::where('aktif', 'Y')->pluck('id')->toArray();
        $unitKerjaList = UnitKerja::pluck('id')->toArray();

        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:15',
            'alamat_domisili' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'kabupaten_asal' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => ['required', Rule::in($agamaList)],
            'golongan_darah' => 'required|in:A,B,AB,O',
            'status_pegawai' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'jenis_asn' => 'required|in:PNS,PPPK',
            'jabatan_id' => ['required', Rule::in($jabatanIdList)],
            'unit_kerja_id' => ['required', Rule::in($unitKerjaList)],
            'tmt' => 'required|date',
            'tmt_jabatan' => 'required|date',
            'golongan' => ['required', Rule::in($pangkatList)],
        ]);

        $statusKawinMapping = [
            'Belum Menikah' => 'BM',
            'Menikah' => 'M',
            'Cerai Hidup' => 'CH',
            'Cerai Mati' => 'CM',
        ];

        $pegawai->nama_lengkap = Session::get('name');
        $pegawai->jenis_kelamin = $validated['jenis_kelamin'] === 'Laki-laki' ? 'L' : 'P';
        $pegawai->tempat_lahir = $validated['tempat_lahir'];
        $pegawai->tanggal_lahir = $validated['tanggal_lahir'];
        $pegawai->gol_darah = $validated['golongan_darah'];
        $pegawai->status_kawin = $statusKawinMapping[$validated['status_pegawai']] ?? 'BM';
        $pegawai->status_pegawai = $validated['jenis_asn'];
        $pegawai->no_nik = $validated['nik'];
        $pegawai->email = $validated['email'];
        $pegawai->no_hp = $validated['no_hp'];
        $pegawai->alamat = $validated['alamat_domisili'];
        $pegawai->kabupaten_asal = $validated['kabupaten_asal'];

        // Set nama_agama
        $agama = Agama::where('nama', $validated['agama'])->first();
        if ($agama) {
            $pegawai->nama_agama = $agama->nama;
        }

        // Set nama_pangkat and golongan_pangkat
        $pangkat = Pangkat::where('golongan', $validated['golongan'])->first();
        if ($pangkat) {
            $pegawai->nama_pangkat = $pangkat->nama;
            $pegawai->golongan_pangkat = $pangkat->golongan;
        }

        // Auto-set jabatan detail columns from jabatans table
        $jabatan = Jabatan::find($validated['jabatan_id']);
        if ($jabatan) {
            $pegawai->jenis_jabatan = $jabatan->jenis_jabatan;
            $pegawai->nama_jabatan = $jabatan->nama_jabatan;
            $pegawai->eselon_jabatan = $jabatan->eselon;
        }

        // Set unit_kerja_id
        $pegawai->unit_kerja_id = $validated['unit_kerja_id'];

        $pegawai->tmt = $validated['tmt'];
        $pegawai->tmt_jabatan = $validated['tmt_jabatan'];
        $pegawai->save();

        // Update status profil dasar lengkap di users table
        $user = User::where('pegawai_id', Session::get('identifier'))->first();
        if ($user) {
            $user->profil_dasar_lengkap = true;
            $user->save();

            // Juga update session agar status tetap sinkron saat user masih aktif
            Session::put('profil_dasar_lengkap', true);
        }
    }

    /**
     * Menyimpan Dokumen Keluarga (Step 1)
     */
    private function storeDokumenKeluarga(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            // Data Pasangan
            'nik_pasangan' => 'nullable|string|max:16',
            'nama_pasangan' => 'nullable|string|max:255',
            'status_pasangan_select' => 'nullable|in:SUAMI,ISTRI',
            'status_hidup_pasangan' => 'nullable|in:Hidup,Meninggal',
            'tempat_lahir_pasangan' => 'nullable|string|max:100',
            'tanggal_lahir_pasangan' => 'nullable|date',
            'pekerjaan_pasangan' => 'nullable|string|max:100',
            'no_akta_nikah' => 'nullable|string|max:255',

            // Data Anak
            'anak' => 'nullable|array',
            'anak.*.nama' => 'required_with:anak|string|max:255',
            'anak.*.nik' => 'nullable|string|max:16',
            'anak.*.tempat_lahir' => 'nullable|string|max:100',
            'anak.*.tanggal_lahir' => 'nullable|date',
            'anak.*.status_anak' => 'nullable|in:Kandung,Tiri,Angkat',
            'anak.*.status_kawin' => 'nullable|in:Menikah,Belum Menikah,Cerai Hidup,Cerai Mati',
            'anak.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'anak.*.old_file' => 'nullable|string',

            // Data Orang Tua
            'nik_ayah' => 'nullable|string|max:16',
            'nama_ayah' => 'nullable|string|max:255',
            'alamat_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'status_ayah' => 'nullable|in:Hidup,Meninggal',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'nik_ibu' => 'nullable|string|max:16',
            'nama_ibu' => 'nullable|string|max:255',
            'alamat_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'status_ibu' => 'nullable|in:Hidup,Meninggal',
            'pekerjaan_ibu' => 'nullable|string|max:100',

            // Data Mertua
            'nik_ayah_mertua' => 'nullable|string|max:16',
            'nama_ayah_mertua' => 'nullable|string|max:255',
            'tanggal_lahir_ayah_mertua' => 'nullable|date',
            'status_ayah_mertua' => 'nullable|in:Hidup,Meninggal',
            'pekerjaan_ayah_mertua' => 'nullable|string|max:100',
            'file_ayah_mertua' => 'nullable|file|mimes:pdf|max:1024',
            'nama_ibu_mertua' => 'nullable|string|max:255',
            'tanggal_lahir_ibu_mertua' => 'nullable|date',
            'status_ibu_mertua' => 'nullable|in:Hidup,Meninggal',
            'pekerjaan_ibu_mertua' => 'nullable|string|max:100',
            'file_ibu_mertua' => 'nullable|file|mimes:pdf|max:1024',
            'nik_ibu_mertua' => 'nullable|string|max:16',

            // Data Saudara
            'saudara' => 'nullable|array',
            'saudara.*.nik' => 'nullable|string|max:16',
            'saudara.*.nama' => 'nullable|string|max:255',
            'saudara.*.jenis_kelamin' => 'nullable|in:P,L',
            'saudara.*.status_kawin' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'saudara.*.status_saudara' => 'nullable|in:Kandung,Tiri,Angkat',
            'saudara.*.tanggal_lahir' => 'nullable|date',
            'saudara.*.pekerjaan' => 'nullable|string|max:100',
            'saudara.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'saudara.*.old_file' => 'nullable|string',
        ]);

        $dataKeluarga = [];

        // Reset family data on this pegawai so every submission replaces previous rows.
        Pasangan::where('pegawai_id', $pegawai->id)->delete();
        Anak::where('pegawai_id', $pegawai->id)->delete();
        OrangTua::where('pegawai_id', $pegawai->id)->delete();
        Mertua::where('pegawai_id', $pegawai->id)->delete();
        Saudara::where('pegawai_id', $pegawai->id)->delete();

        // Data Pasangan
        if (!empty($validated['nama_pasangan'])) {
            $dataKeluarga['pasangan'] = [
                'nik' => $validated['nik_pasangan'] ?? null,
                'nama' => $validated['nama_pasangan'],
                'status' => $validated['status_pasangan_select'] ?? null,
                'status_hidup' => $validated['status_hidup_pasangan'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir_pasangan'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir_pasangan'] ?? null,
                'pekerjaan' => $validated['pekerjaan_pasangan'] ?? null,
                'no_akta_nikah' => $validated['no_akta_nikah'] ?? null,
            ];

            Pasangan::create([
                'pegawai_id' => $pegawai->id,
                'nama_pegawai' => $pegawai->nama_lengkap,
                'nik' => $validated['nik_pasangan'] ?? null,
                'nama' => $validated['nama_pasangan'],
                'status' => $validated['status_pasangan_select'] ?? null,
                'status_hidup' => $validated['status_hidup_pasangan'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir_pasangan'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir_pasangan'] ?? null,
                'pekerjaan' => $validated['pekerjaan_pasangan'] ?? null,
                'no_akta_nikah' => $validated['no_akta_nikah'] ?? null,
            ]);
        }

        // Data Anak
        if (!empty($validated['anak'])) {
            $dataKeluarga['anak'] = [];
            foreach ($validated['anak'] as $index => $anak) {
                if (!empty($anak['nama'])) {
                    // Use old_file if no new file uploaded, otherwise store new file
                    $filePath = null;
                    if ($request->hasFile("anak.{$index}.file")) {
                        $filePath = $this->storeFile($request->file("anak.{$index}.file"), 'keluarga/anak');
                    } elseif (!empty($anak['old_file'])) {
                        $filePath = $anak['old_file'];
                    }
                    
                    $dataKeluarga['anak'][] = [
                        'nama' => $anak['nama'],
                        'nik' => $anak['nik'] ?? null,
                        'tempat_lahir' => $anak['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $anak['tanggal_lahir'] ?? null,
                        'status_anak' => $anak['status_anak'] ?? null,
                        'status_kawin' => $anak['status_kawin'] ?? null,
                        'file' => $filePath,
                    ];

                    Anak::create([
                        'pegawai_id' => $pegawai->id,
                        'nama_pegawai' => $pegawai->nama_lengkap,
                        'nik' => $anak['nik'] ?? null,
                        'nama' => $anak['nama'],
                        'jenis_kelamin' => $anak['jenis_kelamin'] ?? null,
                        'tempat_lahir' => $anak['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $anak['tanggal_lahir'] ?? null,
                        'pekerjaan' => $anak['pekerjaan'] ?? null,
                        'status_anak' => $anak['status_anak'] ?? null,
                        'status_kawin' => $anak['status_kawin'] ?? null,
                        'file' => $filePath,
                    ]);
                }
            }
        }

        // Data Orang Tua
        $dataKeluarga['orang_tua'] = [
            'ayah' => [
                'nik' => $validated['nik_ayah'] ?? null,
                'nama' => $validated['nama_ayah'] ?? null,
                'alamat' => $validated['alamat_ayah'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir_ayah'] ?? null,
                'status_hidup' => $validated['status_ayah'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ayah'] ?? null,
            ],
            'ibu' => [
                'nik' => $validated['nik_ibu'] ?? null,
                'nama' => $validated['nama_ibu'] ?? null,
                'alamat' => $validated['alamat_ibu'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir_ibu'] ?? null,
                'status_hidup' => $validated['status_ibu'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ibu'] ?? null,
            ],
        ];

        if (!empty($validated['nama_ayah'])) {
            OrangTua::create([
                'pegawai_id' => $pegawai->id,
                'nik' => $validated['nik_ayah'] ?? null,
                'nama' => $validated['nama_ayah'],
                'alamat' => $validated['alamat_ayah'] ?? null,
                'tempat_lahir' => null,
                'tanggal_lahir' => $validated['tanggal_lahir_ayah'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ayah'] ?? null,
                'status_hub' => 'Ayah',
                'status_hidup' => $validated['status_ayah'] ?? null,
            ]);
        }

        if (!empty($validated['nama_ibu'])) {
            OrangTua::create([
                'pegawai_id' => $pegawai->id,
                'nik' => $validated['nik_ibu'] ?? null,
                'nama' => $validated['nama_ibu'],
                'alamat' => $validated['alamat_ibu'] ?? null,
                'tempat_lahir' => null,
                'tanggal_lahir' => $validated['tanggal_lahir_ibu'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ibu'] ?? null,
                'status_hub' => 'Ibu',
                'status_hidup' => $validated['status_ibu'] ?? null,
            ]);
        }

        // Data Saudara
        $saudaraRows = [];
        if (!empty($validated['saudara']) && is_array($validated['saudara'])) {
            $dataKeluarga['saudara'] = [];
            foreach ($validated['saudara'] as $index => $sdr) {
                if (!empty($sdr['nama'])) {
                    // Use old_file if no new file uploaded, otherwise store new file
                    $filePath = null;
                    if ($request->hasFile("saudara.{$index}.file")) {
                        $filePath = $this->storeFile($request->file("saudara.{$index}.file"), 'keluarga/saudara');
                    } elseif (!empty($sdr['old_file'])) {
                        $filePath = $sdr['old_file'];
                    }
                    
                    $dataKeluarga['saudara'][] = [
                        'nik' => $sdr['nik'] ?? null,
                        'nama' => $sdr['nama'],
                        'jenis_kelamin' => $sdr['jenis_kelamin'] ?? null,
                        'status_kawin' => $sdr['status_kawin'] ?? null,
                        'status_saudara' => $sdr['status_saudara'] ?? null,
                        'tanggal_lahir' => $sdr['tanggal_lahir'] ?? null,
                        'pekerjaan' => $sdr['pekerjaan'] ?? null,
                        'file' => $filePath,
                    ];
                    Saudara::create([
                        'pegawai_id' => $pegawai->id,
                        'nama_pegawai' => $pegawai->nama_lengkap,
                        'nik' => $sdr['nik'] ?? null,
                        'nama' => $sdr['nama'],
                        'jenis_kelamin' => $sdr['jenis_kelamin'] ?? null,
                        'tanggal_lahir' => $sdr['tanggal_lahir'] ?? null,
                        'pekerjaan' => $sdr['pekerjaan'] ?? null,
                        'status_hub' => $sdr['status_saudara'] ?? null,
                        'status_kawin' => $sdr['status_kawin'] ?? null,
                        'file' => $filePath,
                    ]);
                    $saudaraRows[] = $sdr;
                }
            }
        }

        // Data Mertua
        $fileAyahMertua = $this->storeFile($request->file('file_ayah_mertua'), 'keluarga/mertua');
        $fileIbuMertua = $this->storeFile($request->file('file_ibu_mertua'), 'keluarga/mertua');

        $dataKeluarga['mertua'] = [
            'ayah' => [
                'nik' => $validated['nik_ayah_mertua'] ?? null,
                'nama' => $validated['nama_ayah_mertua'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir_ayah_mertua'] ?? null,
                'status_hidup' => $validated['status_ayah_mertua'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ayah_mertua'] ?? null,
                'file' => $fileAyahMertua,
            ],
            'ibu' => [
                'nik' => $validated['nik_ibu_mertua'] ?? null,
                'nama' => $validated['nama_ibu_mertua'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir_ibu_mertua'] ?? null,
                'status_hidup' => $validated['status_ibu_mertua'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ibu_mertua'] ?? null,
                'file' => $fileIbuMertua,
            ],
        ];

        if (!empty($validated['nama_ayah_mertua'])) {
            Mertua::create([
                'pegawai_id' => $pegawai->id,
                'nama_pegawai' => $pegawai->nama_lengkap,
                'nik' => $validated['nik_ayah_mertua'] ?? null,
                'nama' => $validated['nama_ayah_mertua'],
                'tempat_lahir' => null,
                'tanggal_lahir' => $validated['tanggal_lahir_ayah_mertua'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ayah_mertua'] ?? null,
                'status_hub' => 'Ayah Mertua',
                'status_hidup' => $validated['status_ayah_mertua'] ?? null,
                'file' => $fileAyahMertua,
            ]);
        }

        if (!empty($validated['nama_ibu_mertua'])) {
            Mertua::create([
                'pegawai_id' => $pegawai->id,
                'nama_pegawai' => $pegawai->nama_lengkap,
                'nik' => $validated['nik_ibu_mertua'] ?? null,
                'nama' => $validated['nama_ibu_mertua'],
                'tempat_lahir' => null,
                'tanggal_lahir' => $validated['tanggal_lahir_ibu_mertua'] ?? null,
                'pekerjaan' => $validated['pekerjaan_ibu_mertua'] ?? null,
                'status_hub' => 'Ibu Mertua',
                'status_hidup' => $validated['status_ibu_mertua'] ?? null,
                'file' => $fileIbuMertua,
            ]);
        }

        $pegawai->data_keluarga = $dataKeluarga;
        $pegawai->save();
    }

    /**
     * Menyimpan Riwayat Pendidikan (Step 2)
     */
    private function storeRiwayatPendidikan(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'pendidikan' => 'nullable|array',
            'pendidikan.*.jenjang' => 'required_with:pendidikan|string|max:50',
            'pendidikan.*.nama_sekolah' => 'required_with:pendidikan|string|max:255',
            'pendidikan.*.tahun_masuk' => 'nullable|string|max:4',
            'pendidikan.*.tahun_lulus' => 'nullable|string|max:4',
            'pendidikan.*.nomor_ijazah' => 'nullable|string|max:100',
            'pendidikan.*.nama_pejabat' => 'nullable|string|max:255',
            'pendidikan.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'pendidikan.*.old_file' => 'nullable|string',
            'pendidikan.*._delete' => 'nullable|in:1',
            'pendidikan.*.id' => 'nullable|integer',
        ]);

        // Hapus data yang di-mark _delete=1
        $deleted = false;
        if (!empty($validated['pendidikan'])) {
            foreach ($validated['pendidikan'] as $index => $pendidikan) {
                if (!empty($pendidikan['_delete']) && !empty($pendidikan['id'])) {
                    // Hapus relasi jika ada (contoh: file, relasi lain, dsb)
                    $riw = \App\Models\RiwayatPendidikan::find($pendidikan['id']);
                    if ($riw) {
                        // Contoh: hapus file jika ada
                        if ($riw->dokumen && \Storage::disk('public')->exists($riw->dokumen)) {
                            \Storage::disk('public')->delete($riw->dokumen);
                        }
                        // TODO: hapus relasi lain jika ada (tambahkan di sini)
                        $riw->delete();
                        $deleted = true;
                    }
                    continue; // Lewati proses simpan
                }

                if (empty($pendidikan['jenjang'])) {
                    continue;
                }

                $pendidikanMaster = Pendidikan::firstOrCreate([
                    'nama' => $pendidikan['jenjang'],
                ], [
                    'aktif' => 'Y',
                ]);

                $filePath = $this->storeFile($request->file("pendidikan.{$index}.file"), 'pendidikan') ?? $pendidikan['old_file'] ?? null;

                // Update jika ada id, jika tidak create baru
                if (!empty($pendidikan['id'])) {
                    $riw = \App\Models\RiwayatPendidikan::find($pendidikan['id']);
                    if ($riw) {
                        $riw->update([
                            'pendidikan_id' => $pendidikanMaster->id,
                            'nama_instansi' => $pendidikan['nama_sekolah'],
                            'tahun_masuk' => $pendidikan['tahun_masuk'] ?? null,
                            'tahun_keluar' => $pendidikan['tahun_lulus'] ?? null,
                            'no_ijazah' => $pendidikan['nomor_ijazah'] ?? null,
                            'nama_pejabat' => $pendidikan['nama_pejabat'] ?? null,
                            'dokumen' => $filePath,
                        ]);
                    }
                } else {
                    \App\Models\RiwayatPendidikan::create([
                        'pegawai_id' => $pegawai->id,
                        'nama_pegawai' => $pegawai->nama_lengkap,
                        'pendidikan_id' => $pendidikanMaster->id,
                        'nama_instansi' => $pendidikan['nama_sekolah'],
                        'tahun_masuk' => $pendidikan['tahun_masuk'] ?? null,
                        'tahun_keluar' => $pendidikan['tahun_lulus'] ?? null,
                        'no_ijazah' => $pendidikan['nomor_ijazah'] ?? null,
                        'nama_pejabat' => $pendidikan['nama_pejabat'] ?? null,
                        'dokumen' => $filePath,
                    ]);
                }
            }
        }

        // Jika ada data dihapus, set notifikasi
        if ($deleted && $request->wantsJson()) {
            \Session::flash('success', 'data berhasil dihapus! segera perbarui');
        }
    }

    /**
     * Menyimpan Riwayat Diklat (Step 3)
     */
    private function storeRiwayatDiklat(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'diklat' => 'nullable|array',
            'diklat.*.nama' => 'required_with:diklat|string|max:255',
            'diklat.*.penyelenggara' => 'required_with:diklat|string|max:255',
            'diklat.*.nomor_sertifikat' => 'nullable|string|max:100',
            'diklat.*.tahun' => 'nullable|string|max:4',
            'diklat.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'diklat.*.old_file' => 'nullable|string',
        ]);

        RiwayatDiklat::where('pegawai_id', $pegawai->id)->delete();

        if (!empty($validated['diklat'])) {
            foreach ($validated['diklat'] as $index => $diklat) {
                if (empty($diklat['nama'])) {
                    continue;
                }

                RiwayatDiklat::create([
                    'pegawai_id' => $pegawai->id,
                    'nama_pegawai' => $pegawai->nama_lengkap,
                    'nama_diklat' => $diklat['nama'],
                    'penyelenggara' => $diklat['penyelenggara'],
                    'no_sertifikat' => $diklat['nomor_sertifikat'] ?? null,
                    'tahun' => $diklat['tahun'] ?? null,
                    'dokumen' => $this->storeFile($request->file("diklat.{$index}.file"), 'diklat') ?? $diklat['old_file'] ?? null,
                ]);
            }
        }
    }

    /**
     * Menyimpan Riwayat Jabatan (Step 4)
     */
    private function storeRiwayatJabatan(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'riwayat_jabatan' => 'nullable|array',
            'riwayat_jabatan.*.jenis_jabatan' => 'nullable|string|in:STRUKTURAL,JFT,JFU',
            'riwayat_jabatan.*.eselon' => 'nullable|string|max:10',
            'riwayat_jabatan.*.nama_jabatan' => 'nullable|string|max:255',
            'riwayat_jabatan.*.no_sk' => 'nullable|string|max:100',
            'riwayat_jabatan.*.tmt' => 'nullable|date',
            'riwayat_jabatan.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'riwayat_jabatan.*.old_file' => 'nullable|string',
        ]);

        RiwayatJabatan::where('pegawai_id', $pegawai->id)->delete();

        if (!empty($validated['riwayat_jabatan'])) {
            foreach ($validated['riwayat_jabatan'] as $index => $jabatan) {
                if (empty($jabatan['jenis_jabatan']) && empty($jabatan['nama_jabatan']) && empty($jabatan['no_sk'])) {
                    continue;
                }

                // Use new file if uploaded, otherwise preserve old file
                $dokumen = $this->storeFile($request->file("riwayat_jabatan.{$index}.file"), 'jabatan');
                if (!$dokumen && !empty($jabatan['old_file'])) {
                    $dokumen = $jabatan['old_file'];
                }

                RiwayatJabatan::create([
                    'pegawai_id' => $pegawai->id,
                    'nama_pegawai' => $pegawai->nama_lengkap,
                    'jenis_jabatan' => $jabatan['jenis_jabatan'] ?? null,
                    'nama_jabatan' => $jabatan['nama_jabatan'] ?? null,
                    'eselon' => $jabatan['eselon'] ?? null,
                    'unit_kerja_id' => null,
                    'tmt' => $jabatan['tmt'] ?? null,
                    'no_sk' => $jabatan['no_sk'] ?? null,
                    'dokumen' => $dokumen,
                ]);
            }
        }
    }

    /**
     * Menyimpan Riwayat Penghargaan (Step 5)
     */
    private function storeRiwayatPenghargaan(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'award' => 'nullable|array',
            'award.*.nama' => 'required_with:award|string|max:255',
            'award.*.tahun' => 'required_with:award|string|max:4',
            'award.*.instansi' => 'required_with:award|string|max:255',
            'award.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'award.*.old_file' => 'nullable|string',
        ]);

        Penghargaan::where('pegawai_id', $pegawai->id)->delete();

        if (!empty($validated['award'])) {
            foreach ($validated['award'] as $index => $award) {
                if (empty($award['nama'])) {
                    continue;
                }

                // Use new file if uploaded, otherwise preserve old file
                $dokumen = $this->storeFile($request->file("award.{$index}.file"), 'penghargaan');
                if (!$dokumen && !empty($award['old_file'])) {
                    $dokumen = $award['old_file'];
                }

                Penghargaan::create([
                    'pegawai_id' => $pegawai->id,
                    'nama_pegawai' => $pegawai->nama_lengkap,
                    'nama_penghargaan' => $award['nama'],
                    'tahun' => $award['tahun'],
                    'instansi_pemberi' => $award['instansi'],
                    'dokumen' => $dokumen,
                ]);
            }
        }
    }

    /**
     * Menyimpan Riwayat Sertifikasi (Step 6)
     */
    private function storeRiwayatSertifikasi(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'sertif' => 'nullable|array',
            'sertif.*.nama' => 'required_with:sertif|string|max:255',
            'sertif.*.tahun' => 'required_with:sertif|string|max:4',
            'sertif.*.lembaga' => 'required_with:sertif|string|max:255',
            'sertif.*.file' => 'nullable|file|mimes:pdf|max:1024',
            'sertif.*.old_file' => 'nullable|string',
        ]);

        Sertifikasi::where('pegawai_id', $pegawai->id)->delete();

        if (!empty($validated['sertif'])) {
            foreach ($validated['sertif'] as $index => $sertif) {
                if (empty($sertif['nama'])) {
                    continue;
                }

                // Use new file if uploaded, otherwise preserve old file
                $dokumen = $this->storeFile($request->file("sertif.{$index}.file"), 'sertifikasi');
                if (!$dokumen && !empty($sertif['old_file'])) {
                    $dokumen = $sertif['old_file'];
                }

                Sertifikasi::create([
                    'pegawai_id' => $pegawai->id,
                    'nama_pegawai' => $pegawai->nama_lengkap,
                    'nama_sertifikasi' => $sertif['nama'],
                    'tahun' => $sertif['tahun'],
                    'lembaga_pelaksana' => $sertif['lembaga'],
                    'dokumen' => $dokumen,
                ]);
            }
        }
    }

    /**
     * Menyimpan Identitas Legal (Step 7)
     */
    private function storeIdentitasLegal(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nik_ktp' => 'nullable|string|max:16',
            'nomor_npwp' => 'nullable|string|max:20',
            'nomor_bpjs' => 'nullable|string|max:20',
            'file_ktp' => 'nullable|file|mimes:pdf|max:1024',
            'file_npwp' => 'nullable|file|mimes:pdf|max:1024',
            'file_bpjs' => 'nullable|file|mimes:pdf|max:1024',
            'file_kk' => 'nullable|file|mimes:pdf|max:1024',
        ]);

        $existing = IdentitasLegal::where('pegawai_id', $pegawai->id)->first();

        $dokKtp = $this->storeFile($request->file('file_ktp'), 'identitas') ?: ($existing?->dok_ktp);
        $dokNpwp = $this->storeFile($request->file('file_npwp'), 'identitas') ?: ($existing?->dok_npwp);
        $dokBpjs = $this->storeFile($request->file('file_bpjs'), 'identitas') ?: ($existing?->dok_bpjs);
        $dokKk = $this->storeFile($request->file('file_kk'), 'identitas') ?: ($existing?->dok_kk);

        IdentitasLegal::updateOrCreate(
            ['pegawai_id' => $pegawai->id],
            [
                'nama_pegawai' => $pegawai->nama_lengkap ?: Session::get('name'),
                'no_ktp' => $validated['nik_ktp'] ?? null,
                'no_npwp' => $validated['nomor_npwp'] ?? null,
                'no_bpjs' => $validated['nomor_bpjs'] ?? null,
                'dok_ktp' => $dokKtp,
                'dok_npwp' => $dokNpwp,
                'dok_bpjs' => $dokBpjs,
                'dok_kk' => $dokKk,
            ]
        );
    }

    /**
     * Helper method untuk menyimpan file
     */
    private function storeFile($file, $folder)
    {
        if (!$file) return null;

        $userId = Session::get('identifier');
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs("drh/{$userId}/{$folder}", $filename, 'public');
    }

    /**
     * Cek kelengkapan DRH
     */
    private function checkDrhCompleteness(Pegawai $pegawai)
    {
        $hasRiwayatPendidikan = !empty($pegawai->riwayat_pendidikan) || RiwayatPendidikan::where('pegawai_id', $pegawai->id)->exists();
        $hasRiwayatDiklat = RiwayatDiklat::where('pegawai_id', $pegawai->id)->exists();
        $hasRiwayatJabatan = RiwayatJabatan::where('pegawai_id', $pegawai->id)->exists();
        $hasRiwayatPenghargaan = Penghargaan::where('pegawai_id', $pegawai->id)->exists();
        $hasRiwayatSertifikasi = Sertifikasi::where('pegawai_id', $pegawai->id)->exists();

        $isComplete = !empty($pegawai->nama_lengkap) &&
                     !empty($pegawai->data_keluarga) &&
                     $hasRiwayatPendidikan &&
                     $hasRiwayatDiklat &&
                     $hasRiwayatJabatan &&
                     $hasRiwayatPenghargaan &&
                     $hasRiwayatSertifikasi &&
                     IdentitasLegal::where('pegawai_id', $pegawai->id)->exists();

        $pegawai->drh_lengkap = $isComplete;
        $pegawai->save();
    }

    /**
     * Collect file paths from saved data for a specific step
     */
    private function collectFilePaths($step, $pegawai)
    {
        $files = [];
        
        switch ($step) {
            case 1: // Keluarga (Pasangan, Anak, Saudara)
                // Pasangan
                if (!empty($pegawai->data_keluarga['pasangan']['file'])) {
                    $files[] = Storage::disk('public')->url($pegawai->data_keluarga['pasangan']['file']);
                }
                // Anak
                if (!empty($pegawai->data_keluarga['anak'])) {
                    foreach ($pegawai->data_keluarga['anak'] as $anak) {
                        if (!empty($anak['file'])) {
                            $files[] = Storage::disk('public')->url($anak['file']);
                        }
                    }
                }
                // Saudara
                if (!empty($pegawai->data_keluarga['saudara'])) {
                    foreach ($pegawai->data_keluarga['saudara'] as $saudara) {
                        if (!empty($saudara['file'])) {
                            $files[] = Storage::disk('public')->url($saudara['file']);
                        }
                    }
                }
                break;
            case 2: // Pendidikan
                $pendidikan = RiwayatPendidikan::where('pegawai_id', $pegawai->id)->get();
                foreach ($pendidikan as $item) {
                    if ($item->dokumen) {
                        $files[] = Storage::disk('public')->url($item->dokumen);
                    }
                }
                break;
            case 3: // Diklat
                $diklat = RiwayatDiklat::where('pegawai_id', $pegawai->id)->get();
                foreach ($diklat as $item) {
                    if ($item->dokumen) {
                        $files[] = Storage::disk('public')->url($item->dokumen);
                    }
                }
                break;
            case 4: // Jabatan
                $jabatanList = RiwayatJabatan::where('pegawai_id', $pegawai->id)->get();
                foreach ($jabatanList as $item) {
                    if ($item->dokumen) {
                        $files[] = Storage::disk('public')->url($item->dokumen);
                    }
                }
                break;
            case 5: // Penghargaan
                $awardList = Penghargaan::where('pegawai_id', $pegawai->id)->get();
                foreach ($awardList as $item) {
                    if ($item->dokumen) {
                        $files[] = Storage::disk('public')->url($item->dokumen);
                    }
                }
                break;
            case 6: // Sertifikasi
                $sertifikat = Sertifikasi::where('pegawai_id', $pegawai->id)->get();
                foreach ($sertifikat as $item) {
                    if ($item->dokumen) {
                        $files[] = Storage::disk('public')->url($item->dokumen);
                    }
                }
                break;
            case 7: // Identitas Legal
                $identitas = IdentitasLegal::where('pegawai_id', $pegawai->id)->first();
                if ($identitas?->dok_ktp) {
                    $files[] = Storage::disk('public')->url($identitas->dok_ktp);
                }
                if ($identitas?->dok_npwp) {
                    $files[] = Storage::disk('public')->url($identitas->dok_npwp);
                }
                if ($identitas?->dok_bpjs) {
                    $files[] = Storage::disk('public')->url($identitas->dok_bpjs);
                }
                if ($identitas?->dok_kk) {
                    $files[] = Storage::disk('public')->url($identitas->dok_kk);
                }
                break;
        }
        
        return $files;
    }

    /**
     * Halaman Arsip Dokumen Pegawai
     */
    public function arsip()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        // Wajib ganti password dulu sebelum akses arsip
        if (Session::get('is_first_login')) {
            return redirect('/dashboard')->with('error', 'Anda wajib mengganti password terlebih dahulu sebelum mengakses Arsip Dokumen.');
        }

        $userId = Session::get('user_id');
        $documents = Document::where('user_id', $userId)->latest('uploaded_at')->get();

        // Pisahkan dokumen berdasarkan status
        // Tampilkan SEMUA dokumen approved/pending, baik aktif maupun tidak aktif
        $approvedAndPending = $documents->whereIn('status', ['Approved', 'Pending']);
        $rejected = $documents->where('status', 'Rejected');

        $pending = $documents->where('status', 'Pending')->count();
        $approved = $documents->where('status', 'Approved')->count();
        $rejectedCount = $rejected->count();

        $arsips = \App\Models\Arsip::where('aktif', 'ya')->orderBy('nama')->get();

        return view('dashboard.arsip', compact('approvedAndPending', 'rejected', 'pending', 'approved', 'rejectedCount', 'arsips'));
    }

    /**
     * Upload dokumen ke arsip pegawai
     */
    public function uploadDocument(Request $request)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $request->validate([
            'title' => 'required|string|max:150',
            'document' => 'required|file|mimes:pdf|max:2048',
        ], [
            'document.mimes' => 'Dokumen harus berformat PDF.',
            'document.max' => 'Ukuran file maksimum 2 MB.',
        ]);

        $userId = Session::get('user_id');
        $file = $request->file('document');
        $path = $file->storeAs('pegawai_docs/' . $userId, time() . '_' . $file->getClientOriginalName(), 'public');

        // Cek apakah ada pengajuan dokumen yang sama dengan status Pending
        $pendingSame = Document::where('user_id', $userId)
            ->where('title', $request->title)
            ->where('status', 'Pending')
            ->first();

        if ($pendingSame) {
            return redirect('/pegawai/arsip')->with('error', 'Dokumen yang anda upload masih dalam status menunggu, segera hubungi admin');
        }

        Document::create([
            'user_id' => $userId,
            'nama_pegawai' => Session::get('name'),
            'title' => $request->title,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'uploaded_at' => now(),
            'status' => 'Pending',
            'is_active' => true,
        ]);

        // Kirim notifikasi ke Telegram
        $user = Session::get('name');
        $pesan = "📥 *Arsip Baru Masuk*\n\n";
        $pesan .= "👤 Pegawai: " . $user . "\n";
        $pesan .= "📄 Dokumen: " . $request->title . "\n";
        $pesan .= "📅 Tanggal: " . date('d-m-Y H:i:s') . "\n\n";
        $pesan .= "🔍 Segera lakukan verifikasi.";
        TelegramHelper::kirimTelegram($pesan);

        return redirect('/pegawai/arsip')->with('success', 'Dokumen berhasil diunggah. Dokumen akan divalidasi oleh admin.');
    }

    /**
     * Download dokumen
     */
    public function downloadDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $document = Document::where('id', $id)->where('user_id', $userId)->firstOrFail();

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }

    /**
     * Lihat dokumen (preview)
     */
    public function viewDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $document = Document::where('id', $id)->where('user_id', $userId)->firstOrFail();

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($document->file_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '"'
        ]);
    }

    /**
     * Hapus dokumen ditolak
     */
    public function deleteDocument($id)
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $userId = Session::get('user_id');
        $document = Document::where('id', $id)->where('user_id', $userId)->where('status', 'Rejected')->firstOrFail();

        // Hapus file dari storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // Hapus record dari database
        $document->delete();

        return redirect('/pegawai/arsip')->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Admin: Halaman validasi dokumen
     */
    public function adminValidasiDokumen()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $documents = Document::with('user')->latest('uploaded_at')->get();
        $pendingCount = Document::where('status', 'Pending')->count();
        $approvedCount = Document::where('status', 'Approved')->count();
        $rejectedCount = Document::where('status', 'Rejected')->count();

        return view('dashboard.admin_validasi', compact('documents', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Admin: Setujui dokumen
     */
    public function approveDocument($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $document = Document::findOrFail($id);
        
        // Nonaktifkan SEMUA dokumen lain dengan jenis sama (berapapun statusnya)
        // Hanya dokumen yang sedang diapprove yang akan aktif
        Document::where('user_id', $document->user_id)
            ->where('title', $document->title)
            ->where('id', '!=', $id)
            ->update(['is_active' => false]);

        $document->update([
            'status' => 'Approved',
            'rejection_reason' => null,
            'is_active' => true,
        ]);

        return redirect('/admin/validasi-dokumen')->with('success', 'Dokumen berhasil disetujui.');
    }

    /**
     * Admin: Tolak dokumen
     */
    public function rejectDocument(Request $request, $id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'Alasan penolakan harus diisi.',
            'reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $document = Document::findOrFail($id);
        $document->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->reason,
        ]);

        return redirect('/admin/validasi-dokumen')->with('success', 'Dokumen berhasil ditolak.');
    }

    /**
     * Admin: Lihat DRH detail pegawai
     */
    public function adminViewPegawaiDrh($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $user = User::findOrFail($id);
        $drhData = $this->buildAdminDrhData($user);

        return view('dashboard.admin_pegawai_drh', compact('user', 'drhData'));
    }

    /**
     * Admin: Print DRH pegawai dengan kop resmi untuk PDF/print
     */
    public function adminPrintPegawaiDrh($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $user = User::findOrFail($id);
        $drhData = $this->buildAdminDrhData($user);

        return view('dashboard.admin_pegawai_drh_pdf', compact('user', 'drhData'));
    }

    /**
     * Pegawai: Print DRH sendiri dengan kop resmi
     */
    public function pegawaiPrintDrh()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        $user = User::where('pegawai_id', Session::get('identifier'))->first();
        if (!$user) {
            return redirect('/dashboard')->with('error', 'Data user tidak ditemukan.');
        }

        $drhData = $this->buildAdminDrhData($user);

        return view('dashboard.admin_pegawai_drh_pdf', compact('user', 'drhData'));
    }

    private function buildAdminDrhData(User $user)
    {
        $drhData = Pegawai::with([
            'unit_kerja',
            'riwayatPendidikans.pendidikan',
            'riwayatDiklats',
            'riwayatJabatans.unit_kerja',
            'riwayatJabatans.pangkat',
            'riwayatJabatans.jabatan',
            'riwayatJabatans.eselon',
            'penghargaans',
            'sertifikasis',
            'identitasLegal',
        ])
            ->where('id', $user->pegawai_id)
            ->first();

        if (!$drhData) {
            return null;
        }

        $drhData->riwayat_pendidikan = $drhData->riwayatPendidikans->map(function ($item) {
            return [
                'id' => $item->id,
                'pendidikan_id' => $item->pendidikan_id,
                'jenjang' => $item->pendidikan?->nama,
                'nama_sekolah' => $item->nama_instansi,
                'tahun_masuk' => $item->tahun_masuk,
                'tahun_lulus' => $item->tahun_keluar,
                'nomor_ijazah' => $item->no_ijazah,
                'nama_pejabat' => $item->nama_pejabat,
                'file' => $item->dokumen,
            ];
        })->toArray();

        $drhData->riwayat_diklat = $drhData->riwayatDiklats->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama_diklat,
                'penyelenggara' => $item->penyelenggara,
                'nomor_sertifikat' => $item->no_sertifikat,
                'tahun' => $item->tahun,
                'file' => $item->dokumen,
            ];
        })->toArray();

        $drhData->riwayat_jabatan = $drhData->riwayatJabatans->map(function ($item) {
            return [
                'id' => $item->id,
                'jenis_jabatan' => $item->jenis_jabatan,
                'jabatan' => $item->nama_jabatan,
                'nama_jabatan' => $item->nama_jabatan,
                'eselon' => $item->eselon,
                'unit_kerja' => $item->unit_kerja?->name ?? '-',
                'golongan' => $item->pangkat?->golongan ?? '-',
                'no_sk' => $item->no_sk,
                'tmt' => $item->tmt,
                'file' => $item->dokumen,
            ];
        })->toArray();

        $drhData->riwayat_penghargaan = $drhData->penghargaans->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama_penghargaan,
                'tahun' => $item->tahun,
                'instansi' => $item->instansi_pemberi,
                'file' => $item->dokumen,
            ];
        })->toArray();

        $drhData->riwayat_sertifikasi = $drhData->sertifikasis->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama_sertifikasi,
                'tahun' => $item->tahun,
                'lembaga' => $item->lembaga_pelaksana,
                'file' => $item->dokumen,
            ];
        })->toArray();

        $drhData->identitas_legal = [
            'nik_ktp' => $drhData->identitasLegal?->no_ktp,
            'nomor_npwp' => $drhData->identitasLegal?->no_npwp,
            'nomor_bpjs' => $drhData->identitasLegal?->no_bpjs,
            'file_ktp' => $drhData->identitasLegal?->dok_ktp,
            'file_npwp' => $drhData->identitasLegal?->dok_npwp,
            'file_bpjs' => $drhData->identitasLegal?->dok_bpjs,
            'file_kk' => $drhData->identitasLegal?->dok_kk,
        ];

        return $drhData;
    }

    /**
     * Admin: Kelola arsip dokumen per pegawai
     */
    public function adminKelolaArsipPegawai($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $user = User::with(['pegawai.unit_kerja', 'documents' => function ($query) {
            $query->latest('uploaded_at');
        }])->findOrFail($id);

        $documents = $user->documents;
        $pendingCount = $documents->where('status', 'Pending')->count();
        $approvedCount = $documents->where('status', 'Approved')->count();
        $rejectedCount = $documents->where('status', 'Rejected')->count();

        return view('dashboard.admin_pegawai_arsip', compact('user', 'documents', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    /**
     * Admin: View dokumen arsip pegawai
     */
    public function adminViewArsipDocument($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $document = Document::with('user')->findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($document->file_path);
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->original_name . '"'
        ]);
    }

    /**
     * Admin: Download dokumen arsip pegawai
     */
    public function adminDownloadArsipDocument($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $document = Document::with('user')->findOrFail($id);

        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }

    /**
     * Admin: View legal document PDF inline
     */
    public function adminViewLegalDoc($userId, $type)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $filePath = $this->resolveAdminLegalDocumentPath($userId, $type);
        if (!$filePath) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File dokumen tidak ditemukan di server.');
        }

        return response()->file(Storage::disk('public')->path($filePath), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    /**
     * Admin: Download legal document
     */
    public function adminDownloadLegalDoc($userId, $type)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $filePath = $this->resolveAdminLegalDocumentPath($userId, $type);
        if (!$filePath) {
            return back()->with('error', 'Dokumen tidak ditemukan.');
        }

        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File dokumen tidak ditemukan di server.');
        }

        return Storage::disk('public')->download($filePath, basename($filePath));
    }

    /**
     * Admin: Print legal document via browser print dialog
     */
    public function adminPrintLegalDoc($userId, $type)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        return back()->with('error', 'Fitur legal DRH telah dinonaktifkan.');
    }

    /**
     * Resolve legal/family document path for admin access.
     */
    private function resolveAdminLegalDocumentPath($userId, $type)
    {
        $user = User::find($userId);
        if (!$user) {
            return null;
        }

        $pegawai = Pegawai::where('id', $user->pegawai_id)->first();
        if (!$pegawai) {
            return null;
        }

        $identitas = IdentitasLegal::where('pegawai_id', $pegawai->id)->first();

        return match ($type) {
            'pasangan' => data_get($pegawai, 'data_keluarga.pasangan.file'),
            'ktp' => $identitas?->dok_ktp,
            'npwp' => $identitas?->dok_npwp,
            'bpjs' => $identitas?->dok_bpjs,
            'kk' => $identitas?->dok_kk,
            default => null,
        };
    }

    /**
     * Admin: Menampilkan Daftar Pegawai (DUK) - Urutan sesuai NIP
     */
    public function adminDuk()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        // Urutan senioritas golongan DESC (IV/e paling atas, I/a paling bawah)
        $golonganOrder = [
            'IV/e' => 1,  'IV/d' => 2,  'IV/c' => 3,  'IV/b' => 4,  'IV/a' => 5,
            'III/d' => 6,  'III/c' => 7,  'III/b' => 8,  'III/a' => 9,
            'II/d' => 10, 'II/c' => 11, 'II/b' => 12, 'II/a' => 13,
            'I/d' => 14,  'I/c' => 15,  'I/b' => 16,  'I/a' => 17,
        ];

        // Urutan eselon ASC (II/a paling atas)
        $eselonOrder = [
            'II/a' => 1, 'II/b' => 2,
            'III/a' => 3, 'III/b' => 4,
            'IV/a' => 5, 'IV/b' => 6,
        ];

        $pegawai = User::with(['pegawai'])
            ->where('role', 'pegawai')
            ->get()
            ->sortBy(function ($user) use ($golonganOrder, $eselonOrder) {
                $gol = $user->pegawai?->golongan_pangkat ?? '';
                $tmt = $user->pegawai?->tmt ? $user->pegawai->tmt->format('Y-m-d') : '9999-12-31';
                $eselon = $user->pegawai?->eselon_jabatan ?? '';
                $tmtJabatan = $user->pegawai?->tmt_jabatan ? $user->pegawai->tmt_jabatan->format('Y-m-d') : '9999-12-31';

                return [
                    $golonganOrder[$gol] ?? 99,
                    $tmt,
                    $eselonOrder[$eselon] ?? 99,
                    $tmtJabatan,
                ];
            })
            ->values();

        $total_pegawai = $pegawai->count();

        return view('dashboard.admin_duk', compact('pegawai', 'total_pegawai'));
    }

    /**
     * Halaman Pengajuan Berkas
     */
    public function pengajuanBerkas()
    {
        if (!Session::has('role') || Session::get('role') !== 'pegawai') {
            return redirect('/login');
        }

        return view('dashboard.pengajuan_berkas');
    }

    // Hapus Riwayat Pendidikan
    public function deleteRiwayatPendidikan($id)
    {
        $data = \App\Models\RiwayatPendidikan::findOrFail($id);
        // Hapus file jika ada
        if ($data->dokumen && \Storage::disk('public')->exists($data->dokumen)) {
            \Storage::disk('public')->delete($data->dokumen);
        }
        // TODO: hapus relasi lain jika ada
        $data->delete();
        return response()->json(['status' => 'success', 'message' => 'data berhasil dihapus! segera perbarui']);
    }

    // Hapus Riwayat Diklat
    public function deleteRiwayatDiklat($id)
    {
        $data = \App\Models\RiwayatDiklat::findOrFail($id);
        if ($data->dokumen && \Storage::disk('public')->exists($data->dokumen)) {
            \Storage::disk('public')->delete($data->dokumen);
        }
        $data->delete();
        return response()->json(['status' => 'success', 'message' => 'data berhasil dihapus! segera perbarui']);
    }

    // Hapus Riwayat Jabatan
    public function deleteRiwayatJabatan($id)
    {
        $data = \App\Models\RiwayatJabatan::findOrFail($id);
        $data->delete();
        return response()->json(['status' => 'success', 'message' => 'data berhasil dihapus! segera perbarui']);
    }

    // Hapus Riwayat Penghargaan
    public function deleteRiwayatPenghargaan($id)
    {
        $data = \App\Models\Penghargaan::findOrFail($id);
        $data->delete();
        return response()->json(['status' => 'success', 'message' => 'data berhasil dihapus! segera perbarui']);
    }

    // Hapus file dokumen pendidikan saja
    public function deletePendidikanFile($id)
    {
        $data = \App\Models\RiwayatPendidikan::findOrFail($id);
        if ($data->dokumen && \Storage::disk('public')->exists($data->dokumen)) {
            \Storage::disk('public')->delete($data->dokumen);
        }
        $data->dokumen = null;
        $data->save();
        return response()->json(['status' => 'success', 'message' => 'Dokumen berhasil dihapus!']);
    }

    // Hapus file dokumen diklat saja
    public function deleteDiklatFile($id)
    {
        $data = \App\Models\RiwayatDiklat::findOrFail($id);
        if ($data->file && \Storage::disk('public')->exists($data->file)) {
            \Storage::disk('public')->delete($data->file);
        }
        $data->file = null;
        $data->save();
        return response()->json(['status' => 'success', 'message' => 'File dokumen diklat berhasil dihapus!']);
    }

    // Hapus file dokumen jabatan saja
    public function deleteJabatanFile($id)
    {
        $data = \App\Models\RiwayatJabatan::findOrFail($id);
        if ($data->file && \Storage::disk('public')->exists($data->file)) {
            \Storage::disk('public')->delete($data->file);
        }
        $data->file = null;
        $data->save();
        return response()->json(['status' => 'success', 'message' => 'File dokumen jabatan berhasil dihapus!']);
    }

    // Hapus file dokumen penghargaan saja
    public function deletePenghargaanFile($id)
    {
        $data = \App\Models\Penghargaan::findOrFail($id);
        if ($data->file && \Storage::disk('public')->exists($data->file)) {
            \Storage::disk('public')->delete($data->file);
        }
        $data->file = null;
        $data->save();
        return response()->json(['status' => 'success', 'message' => 'File dokumen penghargaan berhasil dihapus!']);
    }

    // Hapus file dokumen sertifikasi saja
    public function deleteSertifikasiFile($id)
    {
        $data = \App\Models\Sertifikasi::findOrFail($id);
        if ($data->file && \Storage::disk('public')->exists($data->file)) {
            \Storage::disk('public')->delete($data->file);
        }
        $data->file = null;
        $data->save();
        return response()->json(['status' => 'success', 'message' => 'File dokumen sertifikasi berhasil dihapus!']);
    }

    /**
     * Superadmin: Ubah Password Pegawai (AJAX)
     */
    public function ubahPassword(Request $request, $id)
    {
        if (!Session::has('role') || Session::get('role') !== 'superadmin') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'password_baru' => 'required|min:8',
            'konfirmasi_password' => 'required|same:password_baru',
        ], [
            'password_baru.required' => 'Password baru harus diisi.',
            'password_baru.min' => 'Password minimal 8 karakter.',
            'konfirmasi_password.required' => 'Konfirmasi password harus diisi.',
            'konfirmasi_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password_baru),
            'last_password_change' => now(),
            'is_first_login' => false,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password pegawai ' . $user->name . ' berhasil diubah.'
        ]);
    }
}


