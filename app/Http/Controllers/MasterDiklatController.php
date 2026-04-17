<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDiklatController extends Controller
{
    public function index()
    {
        $riwayatDiklat = \App\Models\RiwayatDiklat::with('pegawai')
            ->orderBy('nama_pegawai')
            ->get();
        return view('dashboard.master.diklat', compact('riwayatDiklat'));
    }
}
