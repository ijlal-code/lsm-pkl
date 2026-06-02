<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CetakPdfController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstrukturController;

Route::get('/', function () {
    return view('welcome');
});

// Semua route di bawah ini mewajibkan pengguna untuk Login terlebih dahulu
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Halaman Dashboard Umum setelah login
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ==========================================
    // ROUTE PROFIL BAWAAN BREEZE
    // ==========================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // ROUTE CETAK PDF (Bisa diakses pengguna yang login)
    // ==========================================
    Route::get('/cetak/jurnal/{siswa_id}', [CetakPdfController::class, 'cetakJurnal'])->name('cetak.jurnal');
    Route::get('/cetak/nilai/{siswa_id}', [CetakPdfController::class, 'cetakNilai'])->name('cetak.nilai');
    // Tambahkan route cetak_catatan dan cetak_observasi di sini...

    // ==========================================
    // 1. JALUR AKSES: ADMIN (SEKOLAH / KOORDINATOR)
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Halaman Dashboard Admin SMKN 1 Majene</h1>';
        })->name('dashboard');
        
        // Route untuk Kelola Master Data dan Mapping Siswa
        Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('siswa.index');
        Route::put('/siswa/mapping/{id}', [AdminController::class, 'updateMapping'])->name('siswa.mapping');
    });

    // ==========================================
    // 2. JALUR AKSES: GURU PEMBIMBING PKL
    // ==========================================
    Route::middleware(['role:guru_pembimbing'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Halaman Dashboard Guru Pembimbing</h1>';
        })->name('dashboard');

        // Tempat naruh Route monitoring jurnal dan input lembar observasi
    });

    // ==========================================
    // 3. JALUR AKSES: SISWA PKL
    // ==========================================
    Route::middleware(['role:siswa_pkl'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            // Untuk sementara dashboard kita arahkan saja langsung ke daftar jurnal
            return redirect()->route('siswa.jurnal.index');
        })->name('dashboard');

        // Route untuk Jurnal Kegiatan Harian Siswa
        Route::get('/jurnal', [JurnalSiswaController::class, 'index'])->name('jurnal.index');
        Route::get('/jurnal/tambah', [JurnalSiswaController::class, 'create'])->name('jurnal.create');
        Route::post('/jurnal', [JurnalSiswaController::class, 'store'])->name('jurnal.store');
        Route::delete('/jurnal/{id}', [JurnalSiswaController::class, 'destroy'])->name('jurnal.destroy');
    });

   // ==========================================
    // 4. JALUR AKSES: INSTRUKTUR INDUSTRI
    // ==========================================
    Route::middleware(['role:instruktur_industri'])->prefix('instruktur')->name('instruktur.')->group(function () {
        Route::get('/dashboard', function () {
            // Arahkan dashboard instruktur langsung ke halaman validasi jurnal
            return redirect()->route('instruktur.jurnal.index');
        })->name('dashboard');

        // Route Validasi Jurnal
        Route::get('/jurnal', [\App\Http\Controllers\InstrukturController::class, 'jurnalIndex'])->name('jurnal.index');
        Route::put('/jurnal/{id}/update', [\App\Http\Controllers\InstrukturController::class, 'jurnalUpdate'])->name('jurnal.update');
        
        // Route Absensi Siswa
        Route::get('/absensi', [\App\Http\Controllers\InstrukturController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [\App\Http\Controllers\InstrukturController::class, 'absensiStore'])->name('absensi.store');
    });

});

require __DIR__.'/auth.php';