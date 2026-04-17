<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PegawaiDrhPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_contains_drh_link_for_pegawai(): void
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'pegawai_id' => '197501012000031001',
            'password' => Hash::make('rahasia123'),
            'role' => 'pegawai',
            'is_first_login' => false,
        ]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'role' => 'pegawai',
            'name' => $user->name,
            'identifier' => $user->pegawai_id,
            'is_first_login' => false,
        ])->get('/profile');

        $response->assertOk();
        $response->assertSee('/profile/drh');
        $response->assertSee('Daftar Riwayat Hidup');
    }

    public function test_pegawai_can_open_drh_page(): void
    {
        $user = User::create([
            'name' => 'Budi Santoso',
            'pegawai_id' => '197501012000031001',
            'password' => Hash::make('rahasia123'),
            'role' => 'pegawai',
            'is_first_login' => false,
        ]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'role' => 'pegawai',
            'name' => $user->name,
            'identifier' => $user->pegawai_id,
            'is_first_login' => false,
        ])->get('/profile/drh');

        $response->assertOk();
        $response->assertSee('Daftar Riwayat Hidup (DRH)');
        $response->assertSee('A. Profil Dasar');
    }
}
