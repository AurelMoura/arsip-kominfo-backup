<?php

namespace App\Repositories;

use App\Repositories\Contracts\PegawaiRepositoryInterface;
use Illuminate\Support\Facades\Http;

class SplpPegawaiRepository implements PegawaiRepositoryInterface
{
    protected string $baseUrl;
    protected ?string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.splp.url', 'https://api-splp.layanan.go.id/t/bengkulukota.go.id/data_kinerja/1.0/api/pegawai');
        $this->token = config('services.splp.token');
    }

    public function findByNip(string $nip): ?array
    {
        $response = Http::withoutVerifying()
            ->timeout(10)
            ->withToken($this->token)
            ->get("{$this->baseUrl}/{$nip}/get_pegawai");

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        // API bisa return array of objects atau single object
        $pegawai = is_array($data) && isset($data[0]) ? $data[0] : $data;

        if (empty($pegawai)) {
            return null;
        }

        return [
            'nama_lengkap' => $pegawai['nama_lengkap'] ?? $pegawai['nama'] ?? null,
            'nip'          => $pegawai['nip'] ?? $nip,
            'raw'          => $pegawai,
        ];
    }
}
