<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PegawaiDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_login_pegawai_still_sees_dashboard_with_password_modal(): void
    {
        $user = User::create([
            'name' => 'Pegawai Baru',
            'pegawai_id' => '1234567890',
            'password' => Hash::make('rahasia123'),
            'role' => 'pegawai',
            'is_first_login' => true,
        ]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'role' => 'pegawai',
            'name' => $user->name,
            'identifier' => $user->pegawai_id,
            'is_first_login' => true,
        ])->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Keamanan Akun');
    }

    public function test_returning_pegawai_still_sees_dashboard_and_profile_shortcut(): void
    {
        $user = User::create([
            'name' => 'Pegawai Lama',
            'pegawai_id' => '0987654321',
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
        ])->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Selamat Datang');
        $response->assertSee('/profile');
    }
}
