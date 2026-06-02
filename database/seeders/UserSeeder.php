<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Admin Sekolah / Koordinator PKL [cite: 3]
        User::create([
            'name' => 'Admin HKI SMKN 1 Majene',
            'email' => 'admin@smkn1majene.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Guru Pembimbing PKL [cite: 8]
        User::create([
            'name' => 'Guru Pembimbing Rudi',
            'email' => 'guru@smkn1majene.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru_pembimbing',
        ]);

        // 3. Siswa PKL [cite: 13]
        User::create([
            'name' => 'Siswa Ahmad',
            'email' => 'siswa@smkn1majene.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa_pkl',
        ]);

        // 4. Instruktur Industri [cite: 18]
        User::create([
            'name' => 'Instruktur Budi (Dunia Kerja)',
            'email' => 'instruktur@industri.com',
            'password' => Hash::make('password123'),
            'role' => 'instruktur_industri',
        ]);
    }
}