<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurnal;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstrukturController extends Controller
{
    public function dashboard()
    {
        $instruktur = Auth::user();
        
        // Menghitung jumlah siswa yang berada di perusahaan yang sama dengan instruktur
        $siswaBimbingan = User::where('role', 'siswa')
                              ->where('perusahaan_id', $instruktur->perusahaan_id)
                              ->pluck('id');
                              
        $totalSiswa = $siswaBimbingan->count();
        $jurnalMenunggu = Jurnal::whereIn('siswa_id', $siswaBimbingan)->where('status_persetujuan', 'Menunggu')->count();

        return view('instruktur.dashboard', compact('totalSiswa', 'jurnalMenunggu'));
    }

    // ==========================================
    // 1. MANAJEMEN JURNAL & PERSETUJUAN KEGIATAN
    // ==========================================
    public function jurnalIndex()
    {
        $instruktur = Auth::user();
        
        // Ambil data siswa di perusahaan instruktur
        $siswaIds = User::where('role', 'siswa')->where('perusahaan_id', $instruktur->perusahaan_id)->pluck('id');
        
        // Ambil jurnal terbaru dari siswa-siswa tersebut
        $jurnals = Jurnal::whereIn('siswa_id', $siswaIds)->with('siswa')->latest()->get();

        return view('instruktur.jurnal.index', compact('jurnals'));
    }

    public function jurnalSetujui(Request $request, $id)
    {
        $request->validate([
            'catatan_instruktur' => 'nullable|string',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->status_persetujuan = 'Disetujui';
        $jurnal->catatan_instruktur = $request->catatan_instruktur;
        $jurnal->save();

        return redirect()->route('instruktur.jurnal.index')->with('success', 'Jurnal dan kegiatan siswa berhasil disetujui!');
    }

    // ==========================================
    // 2. MENGISI DAFTAR HADIR / ABSENSI
    // ==========================================
    public function absensiIndex()
    {
        $instruktur = Auth::user();
        $siswas = User::where('role', 'siswa')->where('perusahaan_id', $instruktur->perusahaan_id)->get();
        
        // Riwayat absensi terbaru
        $siswaIds = $siswas->pluck('id');
        $riwayatAbsensi = Absensi::whereIn('siswa_id', $siswaIds)->with('siswa')->latest()->limit(50)->get();

        return view('instruktur.absensi.index', compact('siswas', 'riwayatAbsensi'));
    }

    public function absensiStore(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        // Mencegah duplikasi absen di tanggal yang sama untuk siswa yang sama
        $cekAbsen = Absensi::where('siswa_id', $request->siswa_id)->where('tanggal', $request->tanggal)->first();
        if ($cekAbsen) {
            return back()->withErrors(['tanggal' => 'Siswa ini sudah diabsen pada tanggal tersebut.']);
        }

        Absensi::create([
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'status' => $request->status,
        ]);

        return redirect()->route('instruktur.absensi.index')->with('success', 'Daftar hadir siswa berhasil disimpan!');
    }
}