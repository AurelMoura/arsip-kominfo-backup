<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterArsipController extends Controller
{
    public function index()
    {
        $arsips = \App\Models\Arsip::orderBy('nama', 'asc')->get();
        return view('dashboard.master.arsip', compact('arsips'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        \App\Models\Arsip::create(['nama' => $request->nama, 'aktif' => 'ya']);
        return back()->with('success', 'Kategori Arsip berhasil ditambahkan!');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $arsip = \App\Models\Arsip::findOrFail($id);
        $arsip->update(['nama' => $request->nama]);
        return back()->with('success', 'Kategori Arsip berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $arsip = \App\Models\Arsip::findOrFail($id);
        $arsip->delete();
        return back()->with('success', 'Kategori Arsip berhasil dihapus!');
    }
}
