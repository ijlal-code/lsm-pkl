<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurnal;
use App\Models\Absensi;
use App\Models\Observasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        $guruId = Auth::id();
        
        // Menghitung statistik khusus siswa bimbingan guru yang login
        $totalSiswa = User::where('role', 'siswa')->where('guru_id', $guruId)->count();
        $siswaIds = User::where('role', 'siswa')->where('guru_id', $guruId)->pluck('id');
        
        $totalJurnal = Jurnal::whereIn('siswa_id', $siswaIds)->count();
        $jurnalBelumDinilai = Jurnal::whereIn('siswa_id', $siswaIds)->whereNull('feedback_guru')->count();

        return view('guru.dashboard', compact('totalSiswa', 'totalJurnal', 'jurnalBelumDinilai'));
    }

    // ==========================================
    // 1 & 4. MELIHAT DAFTAR SISWA, JURNAL, & ABSENSI
    // ==========================================
    public function siswaIndex()
    {
        // Hanya menampilkan siswa bimbingan guru ini
        $siswas = User::where('role', 'siswa')->where('guru_id', Auth::id())->with('perusahaan')->get();
        return view('guru.siswa.index', compact('siswas'));
    }

    public function siswaDetail($id)
    {
        $siswa = User::where('role', 'siswa')->where('guru_id', Auth::id())->findOrFail($id);
        
        // Mengambil histori Jurnal (termasuk status instruktur dan feedback guru)
        $jurnals = Jurnal::where('siswa_id', $id)->latest()->get();
        
        // Mengambil histori Absensi yang telah diinput oleh Instruktur Industri
        $absensis = Absensi::where('siswa_id', $id)->latest()->get();

        return view('guru.siswa.detail', compact('siswa', 'jurnals', 'absensis'));
    }

    // ==========================================
    // 2. MEMBERIKAN FEEDBACK / CATATAN JURNAL
    // ==========================================
    public function jurnalFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback_guru' => 'required|string',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        
        // Proteksi keamanan: pastikan jurnal ini milik siswa bimbingannya
        $siswa = User::findOrFail($jurnal->siswa_id);
        if ($siswa->guru_id !== Auth::id()) {
            abort(403, 'Akses Ditolak. Siswa ini bukan bimbingan Anda.');
        }

        $jurnal->feedback_guru = $request->feedback_guru;
        $jurnal->save();

        return back()->with('success', 'Feedback dan Catatan Pembimbing Berhasil Disimpan!');
    }

    // ==========================================
    // 3. MENGISI LEMBAR OBSERVASI PKL
    // ==========================================
    public function observasiIndex()
    {
        // Menampilkan daftar siswa beserta data observasinya jika sudah ada
        $siswas = User::where('role', 'siswa')
                      ->where('guru_id', Auth::id())
                      ->with('perusahaan')
                      ->get();
                      
        // Ambil data observasi yang sudah pernah dibuat guru ini
        $observasis = Observasi::where('guru_id', Auth::id())->get()->keyBy('siswa_id');

        return view('guru.observasi.index', compact('siswas', 'observasis'));
    }

    public function observasiStore(Request $request, $siswa_id)
    {
        $request->validate([
            'tanggal_observasi' => 'required|date',
            'nilai_sikap' => 'required|string',
            'nilai_keterampilan' => 'required|string',
            'catatan_observasi' => 'nullable|string',
        ]);

        // Gunakan updateOrCreate agar guru bisa merevisi observasinya
        Observasi::updateOrCreate(
            ['siswa_id' => $siswa_id, 'guru_id' => Auth::id()],
            [
                'tanggal' => $request->tanggal_observasi,
                'aspek_sikap' => $request->nilai_sikap, // Sesuaikan dengan kolom di migration Anda
                'aspek_keterampilan' => $request->nilai_keterampilan,
                'catatan' => $request->catatan_observasi,
            ]
        );

        return redirect()->route('guru.observasi.index')->with('success', 'Lembar Observasi PKL Siswa berhasil disimpan!');
    }
}