<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class InstrukturController extends Controller
{
    // ==========================================
    // MODUL 1: PERSETUJUAN JURNAL
    // ==========================================
    public function jurnalIndex()
    {
        // Mencari ID siswa yang dibimbing oleh instruktur yang sedang login
        $siswaIds = User::where('instruktur_id', Auth::id())->pluck('id');
        
        // Mengambil jurnal dari siswa-siswa tersebut
        $jurnals = Jurnal::whereIn('siswa_id', $siswaIds)->orderBy('hari_tanggal', 'desc')->get();
        
        return view('instruktur.jurnal.index', compact('jurnals'));
    }

    public function jurnalUpdate(Request $request, $id)
    {
        $request->validate([
            'status_persetujuan' => 'required|in:pending,disetujui,revisi',
            'catatan_instruktur' => 'nullable|string'
        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update([
            'status_persetujuan' => $request->status_persetujuan,
            'catatan_instruktur' => $request->catatan_instruktur,
            'disetujui_oleh' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Status Jurnal Siswa berhasil diperbarui!');
    }

    // ==========================================
    // MODUL 2: DAFTAR HADIR / ABSENSI
    // ==========================================
    public function absensiIndex(Request $request)
    {
        // Ambil tanggal dari request, jika tidak ada gunakan hari ini
        $tanggal = $request->tanggal ?? date('Y-m-d');
        
        // Ambil data siswa bimbingan
        $siswas = User::where('role', 'siswa_pkl')->where('instruktur_id', Auth::id())->get();
        
        // Ambil data absensi yang sudah diisi pada tanggal tersebut (ubah key menjadi siswa_id)
        $absensis = Absensi::where('instruktur_id', Auth::id())
                           ->where('tanggal', $tanggal)
                           ->get()
                           ->keyBy('siswa_id');

        return view('instruktur.absensi.index', compact('siswas', 'tanggal', 'absensis'));
    }

    public function absensiStore(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array'
        ]);

        foreach ($request->absensi as $siswa_id => $data) {
            Absensi::updateOrCreate(
                // Kondisi pencarian
                ['siswa_id' => $siswa_id, 'tanggal' => $request->tanggal],
                // Data yang diupdate/dibuat
                [
                    'instruktur_id' => Auth::id(),
                    'status' => $data['status'],
                    'jam_masuk' => $data['jam_masuk'] ?? null,
                    'jam_pulang' => $data['jam_pulang'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data absensi tanggal ' . $request->tanggal . ' berhasil disimpan!');
    }
}