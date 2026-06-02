<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurnalSiswaController;
use App\Http\Controllers\DokumenSiswaController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\CetakPdfController;

Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cetak/jurnal/{siswa_id}', [CetakPdfController::class, 'cetakJurnal'])->name('cetak.jurnal');
    Route::get('/cetak/nilai/{siswa_id}', [CetakPdfController::class, 'cetakNilai'])->name('cetak.nilai');

    // 1. ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () { return redirect()->route('admin.siswa.index'); })->name('dashboard');
        Route::get('/siswa', [AdminController::class, 'indexSiswa'])->name('siswa.index');
        Route::put('/siswa/mapping/{id}', [AdminController::class, 'updateMapping'])->name('siswa.mapping');
    });

    // 2. GURU PEMBIMBING
    Route::middleware(['role:guru_pembimbing'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () { return redirect()->route('guru.siswa.index'); })->name('dashboard');
        Route::get('/siswa', [GuruController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/{id}/detail', [GuruController::class, 'detailSiswa'])->name('siswa.detail');
        Route::get('/siswa/{id}/observasi', [GuruController::class, 'observasiIndex'])->name('observasi.index');
        Route::post('/siswa/{id}/observasi', [GuruController::class, 'observasiStore'])->name('observasi.store');
    });

    // 3. SISWA
    Route::middleware(['role:siswa_pkl'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () { return redirect()->route('siswa.jurnal.index'); })->name('dashboard');
        Route::get('/jurnal', [JurnalSiswaController::class, 'index'])->name('jurnal.index');
        Route::get('/jurnal/tambah', [JurnalSiswaController::class, 'create'])->name('jurnal.create');
        Route::post('/jurnal', [JurnalSiswaController::class, 'store'])->name('jurnal.store');
        Route::delete('/jurnal/{id}', [JurnalSiswaController::class, 'destroy'])->name('jurnal.destroy');
        // Modul Penutup Siswa
        Route::get('/dokumen', [DokumenSiswaController::class, 'index'])->name('dokumen.index');
        Route::post('/dokumen', [DokumenSiswaController::class, 'store'])->name('dokumen.store');
    });

    // 4. INSTRUKTUR
    Route::middleware(['role:instruktur_industri'])->prefix('instruktur')->name('instruktur.')->group(function () {
        Route::get('/dashboard', function () { return redirect()->route('instruktur.jurnal.index'); })->name('dashboard');
        Route::get('/jurnal', [InstrukturController::class, 'jurnalIndex'])->name('jurnal.index');
        Route::put('/jurnal/{id}/update', [InstrukturController::class, 'jurnalUpdate'])->name('jurnal.update');
        Route::get('/absensi', [InstrukturController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [InstrukturController::class, 'absensiStore'])->name('absensi.store');
        // Modul Penilaian Instruktur
        Route::get('/nilai', [InstrukturController::class, 'nilaiIndex'])->name('nilai.index');
        Route::post('/nilai', [InstrukturController::class, 'nilaiStore'])->name('nilai.store');
    });
});

require __DIR__.'/auth.php';