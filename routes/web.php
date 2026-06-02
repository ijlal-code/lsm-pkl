<?php

use Illuminate\Support\Facades\Route;

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
    // 1. JALUR AKSES: ADMIN (SEKOLAH / KOORDINATOR) [cite: 3]
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Halaman Dashboard Admin SMKN 1 Majene</h1>';
        })->name('dashboard');
        
        // Tempat naruh Route kelola data siswa, guru, industri, dll [cite: 4, 5, 6]
    });

    // ==========================================
    // 2. JALUR AKSES: GURU PEMBIMBING PKL [cite: 8]
    // ==========================================
    Route::middleware(['role:guru_pembimbing'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Halaman Dashboard Guru Pembimbing</h1>';
        })->name('dashboard');

        // Tempat naruh Route monitoring jurnal dan input lembar observasi [cite: 9, 11]
    });
    

    // ==========================================
    // 3. JALUR AKSES: SISWA PKL [cite: 13]
    // ==========================================
    Route::middleware(['role:siswa_pkl'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Halaman Dashboard Siswa PKL</h1>';
        })->name('dashboard');

        // Tempat naruh Route siswa isi jurnal harian dan isi catatan [cite: 14, 15]
    });

    // ==========================================
    // 4. JALUR AKSES: INSTRUKTUR INDUSTRI [cite: 18]
    // ==========================================
    Route::middleware(['role:instruktur_industri'])->prefix('instruktur')->name('instruktur.')->group(function () {
        Route::get('/dashboard', function () {
            return '<h1>Halaman Dashboard Instruktur Industri</h1>';
        })->name('dashboard');

        // Tempat naruh Route instruktur menyetujui jurnal dan isi absen [cite: 19, 20]
    });

});

require __DIR__.'/auth.php';