<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'username' => 'administrator',
                'password' => Hash::make('adminjagotu'),
                'email' => 'admin@admin.com',
                'nama_lengkap' => 'administrator',
                'alamat' => 'bebas dia mah',
                'role' => 'administrator',
            ],
            [
                'username' => 'petugas',
                'password' => Hash::make('petugasaja'),
                'email' => 'petugas@petugas.com',
                'nama_lengkap' => 'petugas',
                'alamat' => 'smk4',
                'role' => 'petugas',
            ],
        ]);
    }
}
