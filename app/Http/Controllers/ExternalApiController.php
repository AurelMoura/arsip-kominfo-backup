<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PegawaiRepositoryInterface;

class ExternalApiController extends Controller
{
    public function __construct(
        protected PegawaiRepositoryInterface $pegawaiRepository
    ) {}

    public function getPegawaiByNip($nip)
    {
        try {
            $data = $this->pegawaiRepository->findByNip($nip);

            if ($data) {
                return response()->json([
                    'success' => true,
                    'nama_lengkap' => $data['nama_lengkap'],
                ]);
            }

            return response()->json(['success' => false, 'message' => 'NIP tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal terhubung ke server API'], 500);
        }
    }
}