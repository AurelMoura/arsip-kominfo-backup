<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class MasterUnitKerjaController extends Controller
{
    public function index()
    {
        if (!Session::has('role') || !in_array(Session::get('role'), ['admin', 'superadmin'])) {
            return redirect('/login');
        }
        $unitKerjas = UnitKerja::withCount(['riwayatJabatans as asn_count' => function($q) {
            $q->whereHas('pegawai', function($q2) {
                $q2->whereHas('user', function($q3) {
                    $q3->where('role', 'pegawai');
                });
            });
        }])->get();
        return view('dashboard.master.unitkerja', compact('unitKerjas'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $unitKerja = UnitKerja::create(['name' => $request->name]);
        return response()->json(['status' => 'success', 'data' => $unitKerja]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->update(['name' => $request->name]);
        return response()->json(['status' => 'success', 'data' => $unitKerja]);
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        // Hapus semua riwayat jabatan yang terkait (jika ada)
        \App\Models\RiwayatJabatan::where('unit_kerja_id', $id)->delete();
        $unitKerja->delete();
        return response()->json(['status' => 'success']);
    }

    public function asnList($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $asn = User::where('role', 'pegawai')
            ->whereHas('pegawai.riwayatJabatans', function($q) use ($id) {
                $q->where('unit_kerja_id', $id);
            })->get();
        return response()->json(['status' => 'success', 'data' => $asn]);
    }
}
