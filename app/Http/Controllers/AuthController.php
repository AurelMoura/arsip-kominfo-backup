<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserActivityLog;
use App\Helpers\UserActivityHelper;

class AuthController extends Controller
{
    /**
     * Proses Login User
     */
    public function login(Request $request)
    {
        // 1. Cari user berdasarkan NIP/pegawai_id
        $user = User::where('pegawai_id', $request->identifier)->first();

        // 2. Cek apakah user ada dan passwordnya cocok
        if ($user && Hash::check($request->password_input, $user->password)) {

            // Cek apakah akun aktif
            if (!$user->is_active) {
                return back()->with('error', 'Akun Anda tidak aktif. Segera hubungi Admin untuk mengaktifkan kembali.');
            }

            // Catat waktu login terakhir
            $user->update(['last_login_at' => now()]);
            
            // Ambil status profil_dasar_lengkap dari users table
            $profileBasicComplete = (bool) $user->profil_dasar_lengkap;
            
            // 3. Log user activity
            $activityData = UserActivityHelper::captureActivity($request);
            UserActivityLog::create([
                'user_id' => $user->id,
                'username' => $user->name,
                'ip_address' => $activityData['ip_address'],
                'location' => $activityData['location'],
                'user_agent' => $activityData['user_agent'],
                'browser' => $activityData['browser'],
                'os' => $activityData['os'],
                'device' => $activityData['device'],
                'device_type' => $activityData['device_type'],
                'login_at' => now(),
                'status' => 'logged_in',
            ]);
            
            // 4. Simpan data ke dalam Session
            // is_first_login ditambahkan agar sistem tahu status akun pegawai
            Session::put([
                'user_id'        => $user->id,
                'role'           => $user->role,
                'name'           => $user->name,
                'identifier'     => $user->pegawai_id,
                'is_first_login' => (bool) $user->is_first_login,
                'profil_dasar_lengkap' => $profileBasicComplete
            ]);

            return redirect('/dashboard');
        }

        // 5. Jika gagal, balik ke login dengan pesan error
        return back()->with('error', 'Login Gagal! Akun tidak ditemukan atau password salah.');
    }

    /**
     * Mengatur Pengalihan Halaman Dashboard Berdasarkan Role
     */
    public function dashboard()
    {
        // Keamanan: Jika belum login (tidak ada session role), tendang ke login
        if (!Session::has('role')) {
            return redirect('/login');
        }

        $role = Session::get('role');

        // Pintu Masuk 1: Jika role adalah ADMIN
        if ($role == 'admin') {
            return view('dashboard.admin'); 
        }

        // Pintu Masuk 2: Jika role adalah PEGAWAI
        if ($role == 'pegawai') {
            return view('dashboard.pegawai');
        }

        // Pintu Masuk 3: Jika role adalah SUPERADMIN (dashboard sama dengan admin)
        if ($role == 'superadmin') {
            return view('dashboard.admin');
        }

        return redirect('/login')->with('error', 'Role user tidak valid.');
    }

    /**
     * Proses Logout
     */
    public function logout()
    {
        Session::flush(); // Bersihkan semua data session login
        return redirect('/');
    }
}