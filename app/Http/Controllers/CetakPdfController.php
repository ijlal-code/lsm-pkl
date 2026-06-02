<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\User;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakPdfController extends Controller
{
    // Mengambil pengaturan global (Tahun Ajaran, dll) yang diatur Admin
    private function getPengaturan()
    {
        return Pengaturan::pluck('nilai', 'kunci')->toArray();
    }

    // 1. Cetak Jurnal (Sesuai format image_8ccad7.png)
    public function cetakJurnal($siswa_id)
    {
        $siswa = User::findOrFail($siswa_id);
        $jurnals = Jurnal::where('siswa_id', $siswa_id)->get();
        $pengaturan = $this->getPengaturan();

        $pdf = Pdf::loadView('pdf.jurnal', compact('siswa', 'jurnals', 'pengaturan'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Jurnal_PKL_'.$siswa->name.'.pdf');
    }

    // 2. Cetak Daftar Nilai (Sesuai format image_8cca61.png)
   public function cetakNilai($siswa_id)
    {
        $siswa = User::findOrFail($siswa_id);
        $pengaturan = $this->getPengaturan();
        $nilai = \App\Models\Nilai::where('siswa_id', $siswa_id)->first(); // Ambil Nilai Asli
        
        // Menghitung absensi
        $absen = \App\Models\Absensi::where('siswa_id', $siswa_id)->get();
        $rekap_absen = [
            'Sakit' => $absen->where('status', 'Sakit')->count(),
            'Izin' => $absen->where('status', 'Izin')->count(),
            'Alpha' => $absen->where('status', 'Alpha')->count(),
        ];

        $pdf = Pdf::loadView('pdf.nilai', compact('siswa', 'pengaturan', 'nilai', 'rekap_absen'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Nilai_PKL_'.$siswa->name.'.pdf');
    }

    public function cetakCatatan()
    {
        $user = auth()->user();
        
        // Ambil data catatan siswa yang sudah di-approve
        $catatan = \App\Models\CatatanKegiatan::where('user_id', $user->id)
                    ->where('is_approved', true)
                    ->get();
                    
        $data = [
            'nama_siswa' => $user->name,
            'dunia_kerja' => $user->perusahaan->nama ?? 'Belum Diatur', 
            'nama_instruktur' => $user->instruktur->name ?? 'Belum Diatur', 
            'nama_guru' => $user->guru->name ?? 'Belum Diatur', 
            'catatan' => $catatan
        ];

        // Pastikan Anda sudah menginstall barryvdh/laravel-dompdf
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.catatan', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Catatan_Kegiatan_PKL_'.$user->name.'.pdf');
    }

public function cetakObservasi()
    {
        $user = auth()->user();
        
        $observasi = \App\Models\Observasi::where('user_id', $user->id)
                    ->orderBy('hari_tanggal', 'asc')
                    ->get();
                    
        $data = [
            'nama_siswa' => $user->name,
            'kelas' => $user->kelas ?? 'Belum Diatur',
            'dunia_kerja' => $user->perusahaan->nama ?? 'Belum Diatur', 
            'nama_instruktur' => $user->instruktur->name ?? 'Belum Diatur', 
            'nama_guru' => $user->guru->name ?? 'Belum Diatur', 
            'pekerjaan_projek' => $observasi->first()->pekerjaan_projek ?? '-',
            'observasi' => $observasi
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.observasi', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Lembar_Observasi_PKL_'.$user->name.'.pdf');
    }

}