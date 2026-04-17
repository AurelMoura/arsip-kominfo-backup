<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Get distinct jenis_jabatan values.
     */
    public function getJenis(): JsonResponse
    {
        $jenis = Jabatan::where('aktif', 'Y')
            ->select('jenis_jabatan')
            ->distinct()
            ->orderBy('jenis_jabatan')
            ->pluck('jenis_jabatan');

        return response()->json($jenis);
    }

    /**
     * Get distinct eselon values filtered by jenis_jabatan.
     */
    public function getEselon(string $jenis): JsonResponse
    {
        $eselons = Jabatan::where('aktif', 'Y')
            ->where('jenis_jabatan', $jenis)
            ->whereNotNull('eselon')
            ->select('eselon')
            ->distinct()
            ->orderBy('eselon')
            ->pluck('eselon');

        return response()->json($eselons);
    }

    /**
     * Get nama_jabatan list filtered by jenis and/or eselon via query params.
     * Usage: /api/jabatan/nama?jenis=struktural&eselon=II.a
     *        /api/jabatan/nama?jenis=JFT  (for fungsional with null eselon)
     */
    public function getNamaJabatan(Request $request): JsonResponse
    {
        $query = Jabatan::where('aktif', 'Y');

        if ($request->filled('jenis')) {
            $query->where('jenis_jabatan', $request->input('jenis'));
        }

        if ($request->filled('eselon')) {
            $query->where('eselon', $request->input('eselon'));
        } elseif ($request->filled('jenis') && in_array($request->input('jenis'), ['JFU', 'JFT'])) {
            // For fungsional types, if no eselon specified, include null eselon
            $query->whereNull('eselon');
        }

        if ($request->filled('jenis_asn')) {
            $query->whereIn('jenis_asn', [$request->input('jenis_asn'), 'Keduanya']);
        }

        $jabatans = $query->select('id', 'nama_jabatan')
            ->orderBy('nama_jabatan')
            ->get();

        return response()->json($jabatans);
    }
}
