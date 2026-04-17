<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterPenghargaanController extends Controller
{
    public function index()
    {
        $penghargaans = \App\Models\MasterPenghargaan::orderBy('nama_penghargaan', 'asc')->get();
        $riwayatPenghargaan = \App\Models\Penghargaan::with('pegawai')
            ->orderBy('nama_pegawai')
            ->get();
        return view('dashboard.master.penghargaan', compact('penghargaans', 'riwayatPenghargaan'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'nama_penghargaan' => 'required|string|max:255',
            'tahun' => 'nullable|string|max:4',
            'instansi_pemberi' => 'nullable|string|max:255',
        ]);
        \App\Models\MasterPenghargaan::create($request->all());
        return back()->with('success', 'Master Penghargaan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $penghargaan = \App\Models\MasterPenghargaan::findOrFail($id);
        $penghargaan->delete();
        return back()->with('success', 'Master Penghargaan berhasil dihapus!');
    }
}
