<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendidikan;
use App\Models\Pegawai;

class MasterPendidikanController extends Controller
{
    public function index()
    {
        // withCount: hitung total ASN yang punya riwayat pendidikan itu
        // with riwayat_pendidikan dengan pegawai: load daftar ASN untuk modal detail
        $pendidikans = Pendidikan::withCount(['riwayat_pendidikan as pegawais_count' => function ($q) {
            $q->distinct('pegawai_id');
        }])
            ->with(['riwayat_pendidikan' => function ($q) {
                $q->with(['pegawai' => function ($pq) {
                    $pq->with('user:id,pegawai_id')
                       ->select(['id', 'nama_lengkap']);
                }])
                  ->distinct('pegawai_id');
            }])
            ->where('aktif', 'Y')
            ->orderBy('nama', 'asc')
            ->get();

        return view('dashboard.master.pendidikan', compact('pendidikans'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Pendidikan::create(['nama' => $request->nama, 'aktif' => 'Y']);
        return back()->with('success', 'Pendidikan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $pendidikan = Pendidikan::findOrFail($id);
        $pendidikan->update(['nama' => $request->nama]);
        return back()->with('success', 'Pendidikan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pendidikan = Pendidikan::findOrFail($id);
        $pendidikan->delete();
        return back()->with('success', 'Pendidikan berhasil dihapus!');
    }
}
