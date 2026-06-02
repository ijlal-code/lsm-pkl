<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JurnalSiswaController;
use App\Http\Controllers\DokumenSiswaController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\CetakPdfController;

// Import Model untuk kebutuhan statistik di Dashboard
use App\Models\User;
use App\Models\Jurnal;
use App\Models\Perusahaan;

Route::get('/', function () { return view('welcome'); });

// ==========================================
// TERMINAL PENGATUR LALU LINTAS DASHBOARD
// ==========================================
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $role = auth()->user()->role;
    
    // Melempar user ke halaman dashboard spesifik mereka
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'guru') return redirect()->route('guru.dashboard');
    if ($role === 'siswa') return redirect()->route('siswa.dashboard');
    if ($role === 'instruktur') return redirect()->route('instruktur.dashboard');
    
    return abort(403);
})->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // ROUTE PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ROUTE CETAK PDF
    Route::get('/cetak/jurnal/{siswa_id}', [CetakPdfController::class, 'cetakJurnal'])->name('cetak.jurnal');
    Route::get('/cetak/nilai/{siswa_id}', [CetakPdfController::class, 'cetakNilai'])->name('cetak.nilai');

    // Group Rute Khusus Admin/Koordinator PKL dengan Middleware Proteksi Role
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // 1. CRUD Mengelola Data Siswa PKL & Plotting
    Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('siswa.index');
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
    Route::put('/siswa/{id}', [AdminController::class, 'siswaUpdate'])->name('siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');
    
    // 2. CRUD Mengelola Data Guru Pembimbing
    Route::get('/guru', [AdminController::class, 'guruIndex'])->name('guru.index');
    Route::post('/guru', [AdminController::class, 'guruStore'])->name('guru.store');
    Route::put('/guru/{id}', [AdminController::class, 'guruUpdate'])->name('guru.update');
    Route::delete('/guru/{id}', [AdminController::class, 'guruDestroy'])->name('guru.destroy');
    
    // 3. CRUD Mengelola Data Industri & Instruktur
    Route::get('/instruktur', [AdminController::class, 'instrukturIndex'])->name('instruktur.index');
    Route::post('/instruktur', [AdminController::class, 'instrukturStore'])->name('instruktur.store');
    Route::put('/instruktur/{id}', [AdminController::class, 'instrukturUpdate'])->name('instruktur.update');
    Route::delete('/instruktur/{id}', [AdminController::class, 'instrukturDestroy'])->name('instruktur.destroy');
    
    // 4. Mengatur Periode Pelaksanaan & Informasi PKL
    Route::get('/pengaturan', [AdminController::class, 'pengaturanIndex'])->name('pengaturan.index');
    Route::put('/pengaturan', [AdminController::class, 'pengaturanUpdate'])->name('pengaturan.update');
});

   // Group Rute Khusus Guru Pembimbing
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    
    // Dashboard Guru
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    
    // 1 & 4. Manajemen Siswa Bimbingan (Melihat Jurnal & Absensi)
    Route::get('/siswa', [GuruController::class, 'siswaIndex'])->name('siswa.index');
    Route::get('/siswa/{id}', [GuruController::class, 'siswaDetail'])->name('siswa.detail');
    
    // 2. Memberikan Catatan / Feedback Jurnal
    Route::put('/jurnal/{id}/feedback', [GuruController::class, 'jurnalFeedback'])->name('jurnal.feedback');
    
    // 3. Mengisi Lembar Observasi PKL
    Route::get('/observasi', [GuruController::class, 'observasiIndex'])->name('observasi.index');
    Route::post('/observasi/{siswa_id}', [GuruController::class, 'observasiStore'])->name('observasi.store');
});

   // Group Rute Khusus Siswa PKL
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    
    // Dashboard Siswa
    Route::get('/dashboard', [JurnalSiswaController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Jurnal & Catatan Kegiatan
    Route::get('/jurnal', [JurnalSiswaController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/create', [JurnalSiswaController::class, 'create'])->name('jurnal.create');
    Route::post('/jurnal', [JurnalSiswaController::class, 'store'])->name('jurnal.store');
    
    // Melihat Absensi (Hanya View/Read)
    Route::get('/absensi', [JurnalSiswaController::class, 'absensi'])->name('absensi.index');
});

    // Group Rute Khusus Instruktur Industri
Route::middleware(['auth', 'role:instruktur'])->prefix('instruktur')->name('instruktur.')->group(function () {
    
    // Dashboard Instruktur
    Route::get('/dashboard', [InstrukturController::class, 'dashboard'])->name('dashboard');
    
    // 1. Validasi & Persetujuan Jurnal Siswa
    Route::get('/jurnal', [InstrukturController::class, 'jurnalIndex'])->name('jurnal.index');
    Route::put('/jurnal/{id}/setujui', [InstrukturController::class, 'jurnalSetujui'])->name('jurnal.setujui');
    
    // 2. Mengisi & Mengelola Absensi / Daftar Hadir Siswa
    Route::get('/absensi', [InstrukturController::class, 'absensiIndex'])->name('absensi.index');
    Route::post('/absensi', [InstrukturController::class, 'absensiStore'])->name('absensi.store');
    
    // 3. Menilai Siswa (Tambahan sesuai alur LMS PKL, jika diperlukan aksesnya via menu persetujuan kegiatan)
    Route::get('/nilai', [InstrukturController::class, 'nilaiIndex'])->name('nilai.index');
    Route::post('/nilai', [InstrukturController::class, 'nilaiStore'])->name('nilai.store');
});

});

require __DIR__.'/auth.php';