<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya berlaku untuk pegawai
        if (Session::has('role') && Session::get('role') === 'pegawai') {
            $profileBasicComplete = Session::get('profil_dasar_lengkap', false);
            
            // List halaman yang diizinkan sebelum profil lengkap
            $allowedRoutes = ['logout', 'update-password', 'profile.drh-view'];
            
            $currentRoute = $request->route()->getName() ?? '';
            
            // Jika profil belum lengkap dan bukan di route yang diizinkan, redirect ke DRH
            if (!$profileBasicComplete && !in_array($currentRoute, $allowedRoutes)) {
                // Arahkan ke halaman A. PROFIL DASAR jika belum lengkap
                if (!str_contains($request->path(), 'profile/drh')) {
                    return redirect('/profile/drh')->with('warning', 'Silakan lengkapi Profil Dasar terlebih dahulu.');
                }
            }
        }

        return $next($request);
    }
}
