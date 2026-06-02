<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JurnalSiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $totalJurnal = Jurnal::where('siswa_id', $user->id)->count();
        $totalHadir = Absensi::where('siswa_id', $user->id)->where('status', 'Hadir')->count();
        
        return view('siswa.dashboard', compact('totalJurnal', 'totalHadir'));
    }

    public function index()
    {
        // Mengambil histori jurnal beserta feedback guru dan instruktur
        $jurnals = Jurnal::where('siswa_id', Auth::id())->latest()->get();
        return view('siswa.jurnal.index', compact('jurnals'));
    }

    public function create()
    {
        return view('siswa.jurnal.create');
    }

    public function store(Request $request)
    {
        // Validasi sesuai pedoman LMS PKL
        $request->validate([
            'tanggal' => ['required', 'date'],
            'unit_kerja' => ['required', 'string', 'max:255'],
            'nama_pekerjaan' => ['required', 'string', 'max:255'],
            'perencanaan' => ['required', 'string'],
            'pelaksanaan' => ['required', 'string'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('dokumentasi')) {
            $path = $request->file('dokumentasi')->store('dokumentasi_jurnal', 'public');
        }

        Jurnal::create([
            'siswa_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'unit_kerja' => $request->unit_kerja,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'perencanaan' => $request->perencanaan,
            'pelaksanaan' => $request->pelaksanaan,
            'dokumentasi' => $path,
            'status_persetujuan' => 'Menunggu', // Default status saat baru diinput
        ]);

        return redirect()->route('siswa.jurnal.index')->with('success', 'Jurnal dan Catatan Kegiatan Harian berhasil dikirim!');
    }

    public function absensi()
    {
        // Absensi diisi oleh Instruktur Industri, siswa hanya memiliki akses untuk melihat
        $absensis = Absensi::where('siswa_id', Auth::id())->latest()->get();
        return view('siswa.absensi.index', compact('absensis'));
    }
}