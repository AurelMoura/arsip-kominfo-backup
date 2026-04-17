<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterSertifikasiController extends Controller
{
    public function index()
    {
        $sertifikasis = \App\Models\MasterSertifikasi::orderBy('nama_sertifikasi', 'asc')->get();
        $riwayatSertifikasi = \App\Models\Sertifikasi::with('pegawai')
            ->orderBy('nama_pegawai')
            ->get();
        return view('dashboard.master.sertifikasi', compact('sertifikasis', 'riwayatSertifikasi'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'tahun' => 'nullable|string|max:4',
            'lembaga_pemberi' => 'nullable|string|max:255',
        ]);
        \App\Models\MasterSertifikasi::create($request->all());
        return back()->with('success', 'Master Sertifikasi berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $sertifikasi = \App\Models\MasterSertifikasi::findOrFail($id);
        $sertifikasi->delete();
        return back()->with('success', 'Master Sertifikasi berhasil dihapus!');
    }
}
