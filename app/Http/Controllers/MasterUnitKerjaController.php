<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Session;

class MasterUnitKerjaController extends Controller
{
    public function index()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $unitKerjas = UnitKerja::withCount([
            'pegawais as asn_count' => function ($q) {
                $q->whereHas('user', function ($q2) {
                    $q2->where('role', 'pegawai');
                });
            }
        ])->get();

        return view('dashboard.master.unitkerja', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        if (Session::get('role') !== 'superadmin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya superadmin yang dapat menambah unit kerja.'
            ], 403);
        }

        $request->validate(['name' => 'required|string|max:255']);
        $unitKerja = UnitKerja::create(['name' => $request->name]);

        return response()->json([
            'status' => 'success',
            'message' => 'Unit kerja berhasil ditambahkan.',
            'data' => $unitKerja
        ]);
    }

    public function update(Request $request, $id)
    {
        if (Session::get('role') !== 'superadmin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya superadmin yang dapat mengubah unit kerja.'
            ], 403);
        }

        $request->validate(['name' => 'required|string|max:255']);
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->update(['name' => $request->name]);

        return response()->json([
            'status' => 'success',
            'message' => 'Unit kerja berhasil diperbarui.',
            'data' => $unitKerja
        ]);
    }

    public function destroy($id)
    {
        if (Session::get('role') !== 'superadmin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya superadmin yang dapat menghapus unit kerja.'
            ], 403);
        }

        $unitKerja = UnitKerja::findOrFail($id);

        // Kosongkan referensi unit kerja pada pegawai agar unit kerja bisa dihapus aman.
        Pegawai::where('unit_kerja_id', $id)->update(['unit_kerja_id' => null]);

        // Hapus riwayat jabatan yang masih memakai unit kerja ini.
        \App\Models\RiwayatJabatan::where('unit_kerja_id', $id)->delete();

        $unitKerja->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Unit kerja berhasil dihapus.'
        ]);
    }

    public function asnList($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak.'
            ], 403);
        }

        UnitKerja::findOrFail($id);

        $asn = Pegawai::query()
            ->where('unit_kerja_id', $id)
            ->whereHas('user', function ($q) {
                $q->where('role', 'pegawai');
            });

        $asn = $asn
            ->with(['user:id,pegawai_id'])
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap'])
            ->map(function ($pegawai) {
                return [
                    'nip' => $pegawai->id,
                    'nama' => $pegawai->nama_lengkap,
                    'drh_url' => $pegawai->user
                        ? url('/admin/pegawai/' . $pegawai->user->id . '/drh')
                        : null,
                ];
            })
            ->values();

        return response()->json([
            'status' => 'success',
            'data' => $asn,
        ]);
    }

    public function showAsnPage($id)
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }

        $unitKerja = UnitKerja::findOrFail($id);

        $asns = Pegawai::query()
            ->where('unit_kerja_id', $id)
            ->whereHas('user', function ($q) {
                $q->where('role', 'pegawai');
            })
            ->with('user:id,pegawai_id')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap', 'status_pegawai', 'foto_profil']);

        return view('dashboard.master.asn_detail', [
            'backUrl' => url('/master/unitkerja'),
            'heading' => 'Detail ASN Unit Kerja',
            'subHeading' => 'Daftar ASN pada unit kerja ' . $unitKerja->name,
            'referenceName' => $unitKerja->name,
            'referenceType' => 'Unit Kerja',
            'asnCount' => $asns->count(),
            'asns' => $asns,
        ]);
    }
}
