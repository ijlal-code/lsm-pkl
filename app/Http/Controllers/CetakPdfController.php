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
        // Asumsi ada tabel Nilai, data absensi dll.
        
        $pdf = Pdf::loadView('pdf.nilai', compact('siswa', 'pengaturan'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Nilai_PKL_'.$siswa->name.'.pdf');
    }
}