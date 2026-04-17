<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Superadmin
        User::create([
            'pegawai_id' => '0987654321', 
            'name' => 'Superadmin Kominfo',
            'password' => Hash::make('123'), // Lebih aman pakai Hash::make
            'role' => 'superadmin'
        ]);
        
        // Data Admin
        User::create([
            'pegawai_id' => '1111111111', 
            'name' => 'Admin',
            'password' => Hash::make('123'),
            'role' => 'admin'
        ]);

        // Data Pegawai untuk Testing
        User::create([
            'pegawai_id' => '197501012000031001',
            'name' => 'Budi Santoso',
            'password' => Hash::make('123'),
            'role' => 'pegawai',
            'is_first_login' => true
        ]);

        User::create([
            'pegawai_id' => '198001152000032002',
            'name' => 'Siti Aminah',
            'password' => Hash::make('123'),
            'role' => 'pegawai',
            'is_first_login' => true
        ]);

        User::create([
            'pegawai_id' => '199001202000033003',
            'name' => 'Ahmad Rahman',
            'password' => Hash::make('123'),
            'role' => 'pegawai',
            'is_first_login' => true
        ]);
    }
}