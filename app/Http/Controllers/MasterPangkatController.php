<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pangkat;
use App\Models\Pegawai;

class MasterPangkatController extends Controller
{
    public function index()
    {
        // withCount: hitung total ASN per pangkat/golongan
        // with pegawais: load daftar ASN untuk modal detail
        $pangkats = Pangkat::withCount('pegawais')
            ->with(['pegawais' => function ($q) {
                $q->with('user:id,pegawai_id')
                  ->orderBy('nama_lengkap')
                  ->select(['id', 'nama_lengkap', 'golongan_pangkat', 'nama_pangkat', 'status_pegawai']);
            }])
            ->orderBy('jenis_asn')
            ->orderBy('golongan')
            ->get();

        return view('dashboard.master.pangkat', compact('pangkats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'nullable|string|max:255',
            'golongan' => 'required|string|max:50',
            'jenis_asn'=> 'required|in:PNS,PPPK,Keduanya',
        ]);
        Pangkat::create([
            'nama'     => $request->nama ?? '-',
            'golongan' => $request->golongan,
            'jenis_asn'=> $request->jenis_asn,
            'aktif'    => 'Y',
        ]);
        return back()->with('success', 'Data Pangkat / Golongan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'golongan' => 'required|string|max:50',
            'nama'     => 'nullable|string|max:255',
            'jenis_asn'=> 'required|in:PNS,PPPK,Keduanya',
        ]);
        $pangkat = Pangkat::findOrFail($id);
        $pangkat->update([
            'golongan' => $request->golongan,
            'nama'     => $request->nama ?? '-',
            'jenis_asn'=> $request->jenis_asn,
        ]);
        return back()->with('success', 'Pangkat / Golongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pangkat = Pangkat::findOrFail($id);
        $pangkat->delete();
        return back()->with('success', 'Pangkat / Golongan berhasil dihapus!');
    }
}
