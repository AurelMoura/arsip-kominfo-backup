<?php

namespace App\Repositories\Contracts;

interface PegawaiRepositoryInterface
{
    /**
     * Cari data pegawai berdasarkan NIP.
     *
     * @param string $nip
     * @return array|null Data pegawai atau null jika tidak ditemukan
     */
    public function findByNip(string $nip): ?array;
}
