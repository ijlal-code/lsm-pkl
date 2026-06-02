<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurnalSiswaController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\CetakPdfController;

Route::get('/', function () {
    return view('welcome');
});

// Semua route di bawah ini mewajibkan pengguna untuk Login terlebih dahulu
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Halaman Dashboard Umum setelah login
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ROUTE PROFIL BAWAAN BREEZE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTE CETAK PDF
    Route::get('/cetak/jurnal/{siswa_id}', [CetakPdfController::class, 'cetakJurnal'])->name('cetak.jurnal');
    Route::get('/cetak/nilai/{siswa_id}', [CetakPdfController::class, 'cetakNilai'])->name('cetak.nilai');

    // ==========================================
    // 1. JALUR AKSES: ADMIN (SEKOLAH / KOORDINATOR)
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('admin.siswa.index');
        })->name('dashboard');
        
        Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('siswa.index');
        Route::put('/siswa/mapping/{id}', [AdminController::class, 'updateMapping'])->name('siswa.mapping');
    });

    // ==========================================
    // 2. JALUR AKSES: GURU PEMBIMBING PKL
    // ==========================================
    Route::middleware(['role:guru_pembimbing'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('guru.siswa.index');
        })->name('dashboard');

        Route::get('/siswa', [GuruController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/{id}/detail', [GuruController::class, 'detailSiswa'])->name('siswa.detail');
        Route::get('/siswa/{id}/observasi', [GuruController::class, 'observasiIndex'])->name('observasi.index');
        Route::post('/siswa/{id}/observasi', [GuruController::class, 'observasiStore'])->name('observasi.store');
    });

    // ==========================================
    // 3. JALUR AKSES: SISWA PKL
    // ==========================================
    Route::middleware(['role:siswa_pkl'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('siswa.jurnal.index');
        })->name('dashboard');

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
            return redirect()->route('instruktur.jurnal.index');
        })->name('dashboard');

        Route::get('/jurnal', [InstrukturController::class, 'jurnalIndex'])->name('jurnal.index');
        Route::put('/jurnal/{id}/update', [InstrukturController::class, 'jurnalUpdate'])->name('jurnal.update');
        
        Route::get('/absensi', [InstrukturController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [InstrukturController::class, 'absensiStore'])->name('absensi.store');
    });
});

require __DIR__.'/auth.php';