<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Pegawai;

class MasterJabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::withCount('pegawais')
            ->orderBy('jenis_asn')
            ->orderBy('nama_jabatan')
            ->get();

        return view('dashboard.master.jabatan', compact('jabatans'));
    }

    public function showAsn($id)
    {
        $jabatan = Jabatan::withCount('pegawais')
            ->with(['pegawais' => function ($q) {
                $q->with('user:id,pegawai_id,name')
                    ->orderBy('nama_lengkap')
                    ->select(['id', 'nama_lengkap', 'nama_jabatan', 'status_pegawai', 'eselon_jabatan', 'foto_profil']);
            }])
            ->findOrFail($id);

        return view('dashboard.master.asn_detail', [
            'backUrl' => url('/admin/master/jabatan'),
            'heading' => 'Detail ASN Jabatan',
            'subHeading' => 'Daftar ASN dengan jabatan ' . $jabatan->nama_jabatan,
            'referenceName' => $jabatan->nama_jabatan,
            'referenceType' => 'Jabatan',
            'asnCount' => $jabatan->pegawais_count,
            'asns' => $jabatan->pegawais,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_asn'    => 'required|in:PNS,PPPK,Keduanya',
            'nama_jabatan' => 'required|string|max:255',
            'jenis_jabatan'=> 'nullable|string|max:100',
            'eselon'       => 'nullable|string|max:50',
            'golongan'     => 'nullable|string|max:50',
        ]);

        Jabatan::create([
            'jenis_asn'    => $request->jenis_asn,
            'nama_jabatan' => $request->nama_jabatan,
            'jenis_jabatan'=> $request->jenis_jabatan,
            'eselon'       => $request->eselon,
            'golongan'     => $request->golongan,
            'aktif'        => 'Y',
        ]);
        return back()->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_asn'    => 'required|in:PNS,PPPK,Keduanya',
            'nama_jabatan' => 'required|string|max:255',
            'jenis_jabatan'=> 'nullable|string|max:100',
            'eselon'       => 'nullable|string|max:50',
        ]);
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update([
            'jenis_asn'    => $request->jenis_asn,
            'nama_jabatan' => $request->nama_jabatan,
            'jenis_jabatan'=> $request->jenis_jabatan,
            'eselon'       => $request->eselon,
        ]);
        return back()->with('success', 'Jabatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();
        return back()->with('success', 'Jabatan berhasil dihapus!');
    }
}
