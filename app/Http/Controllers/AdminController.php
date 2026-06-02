<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mengambil rekap data untuk Dashboard Monitoring
        $countSiswa = User::where('role', 'siswa')->count();
        $countGuru = User::where('role', 'guru')->count();
        $countInstruktur = User::where('role', 'instruktur')->count();

        return view('admin.dashboard', compact('countSiswa', 'countGuru', 'countInstruktur'));
    }


public function siswaIndex()
{
    $siswas = User::where('role', 'siswa')->latest()->get();
    $gurus = User::where('role', 'guru')->get();
    $perusahaans = \App\Models\Perusahaan::all();
    return view('admin.siswa.index', compact('siswas', 'gurus', 'perusahaans'));
}

public function guruIndex()
{
    $gurus = User::where('role', 'guru')->latest()->get();
    return view('admin.guru.index', compact('gurus'));
}

public function instrukturIndex()
{
    $instrukturs = User::where('role', 'instruktur')->latest()->get();
    return view('admin.instruktur.index', compact('instrukturs'));
}

public function pengaturanIndex()
{
    $pengaturan = Pengaturan::first();
    return view('admin.pengaturan.index', compact('pengaturan'));
}
}