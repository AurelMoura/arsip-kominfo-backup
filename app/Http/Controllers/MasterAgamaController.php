<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agama;
use App\Models\Pegawai;

class MasterAgamaController extends Controller
{
    public function index()
    {
        // withCount: hitung total ASN per agama
        // with pegawais: load daftar ASN untuk modal detail
        $agamas = Agama::withCount('pegawais')
            ->with(['pegawais' => function ($q) {
                $q->with('user:id,pegawai_id')
                  ->orderBy('nama_lengkap')
                  ->select(['id', 'nama_lengkap', 'nama_agama']);
            }])
            ->orderBy('nama', 'asc')
            ->get();

        return view('dashboard.master.agama', compact('agamas'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Agama::create(['nama' => $request->nama, 'aktif' => 'Y']);
        return back()->with('success', 'Agama berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $agama = Agama::findOrFail($id);
        $agama->update(['nama' => $request->nama]);
        return back()->with('success', 'Agama berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $agama = Agama::findOrFail($id);
        $agama->delete();
        return back()->with('success', 'Agama berhasil dihapus!');
    }
}
