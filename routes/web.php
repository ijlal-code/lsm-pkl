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
    if ($role === 'guru_pembimbing') return redirect()->route('guru.dashboard');
    if ($role === 'siswa_pkl') return redirect()->route('siswa.dashboard');
    if ($role === 'instruktur_industri') return redirect()->route('instruktur.dashboard');
    
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

  // ==========================================
    // 1. ADMIN (SEKOLAH / KOORDINATOR)
    // ==========================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Kelola Siswa
        Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('siswa.index');
        Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
        Route::put('/siswa/mapping/{id}', [AdminController::class, 'updateMapping'])->name('siswa.mapping');
        Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');
        
        // Kelola Guru
        Route::get('/guru', [AdminController::class, 'guruIndex'])->name('guru.index');
        Route::post('/guru', [AdminController::class, 'guruStore'])->name('guru.store');
        Route::delete('/guru/{id}', [AdminController::class, 'guruDestroy'])->name('guru.destroy');
        
        // Kelola Instruktur & Perusahaan
        Route::get('/instruktur', [AdminController::class, 'instrukturIndex'])->name('instruktur.index');
        Route::post('/instruktur', [AdminController::class, 'instrukturStore'])->name('instruktur.store');
        Route::delete('/instruktur/{id}', [AdminController::class, 'instrukturDestroy'])->name('instruktur.destroy');
        Route::post('/perusahaan', [AdminController::class, 'perusahaanStore'])->name('perusahaan.store');
        Route::delete('/perusahaan/{id}', [AdminController::class, 'perusahaanDestroy'])->name('perusahaan.destroy');
        
        // Pengaturan Sistem
        Route::get('/pengaturan', [AdminController::class, 'pengaturanIndex'])->name('pengaturan.index');
        Route::post('/pengaturan', [AdminController::class, 'pengaturanStore'])->name('pengaturan.store');
    });

    // ==========================================
    // 2. GURU PEMBIMBING
    // ==========================================
    Route::middleware(['role:guru_pembimbing'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', function () {
            // Ambil data statistik untuk Guru
            $siswaBimbingan = User::where('role', 'siswa_pkl')->where('guru_id', Auth::id())->count();
            return view('guru.dashboard', compact('siswaBimbingan'));
        })->name('dashboard');

        Route::get('/siswa', [GuruController::class, 'index'])->name('siswa.index');
        Route::get('/siswa/{id}/detail', [GuruController::class, 'detailSiswa'])->name('siswa.detail');
        Route::get('/siswa/{id}/observasi', [GuruController::class, 'observasiIndex'])->name('observasi.index');
        Route::post('/siswa/{id}/observasi', [GuruController::class, 'observasiStore'])->name('observasi.store');
    });

    // ==========================================
    // 3. SISWA
    // ==========================================
    Route::middleware(['role:siswa_pkl'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', function () {
            // Ambil data statistik untuk Siswa
            $jumlahJurnal = Jurnal::where('siswa_id', Auth::id())->count();
            $jurnalDisetujui = Jurnal::where('siswa_id', Auth::id())->where('status_persetujuan', 'disetujui')->count();
            return view('siswa.dashboard', compact('jumlahJurnal', 'jurnalDisetujui'));
        })->name('dashboard');

        Route::get('/jurnal', [JurnalSiswaController::class, 'index'])->name('jurnal.index');
        Route::get('/jurnal/tambah', [JurnalSiswaController::class, 'create'])->name('jurnal.create');
        Route::post('/jurnal', [JurnalSiswaController::class, 'store'])->name('jurnal.store');
        Route::delete('/jurnal/{id}', [JurnalSiswaController::class, 'destroy'])->name('jurnal.destroy');
        
        Route::get('/dokumen', [DokumenSiswaController::class, 'index'])->name('dokumen.index');
        Route::post('/dokumen', [DokumenSiswaController::class, 'store'])->name('dokumen.store');
    });

    // ==========================================
    // 4. INSTRUKTUR
    // ==========================================
    Route::middleware(['role:instruktur_industri'])->prefix('instruktur')->name('instruktur.')->group(function () {
        Route::get('/dashboard', function () {
            // Ambil data statistik untuk Instruktur
            $siswaBimbingan = User::where('role', 'siswa_pkl')->where('instruktur_id', Auth::id())->count();
            $siswaIds = User::where('instruktur_id', Auth::id())->pluck('id');
            $jurnalPending = Jurnal::whereIn('siswa_id', $siswaIds)->where('status_persetujuan', 'pending')->count();
            
            return view('instruktur.dashboard', compact('siswaBimbingan', 'jurnalPending'));
        })->name('dashboard');

        Route::get('/jurnal', [InstrukturController::class, 'jurnalIndex'])->name('jurnal.index');
        Route::put('/jurnal/{id}/update', [InstrukturController::class, 'jurnalUpdate'])->name('jurnal.update');
        Route::get('/absensi', [InstrukturController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [InstrukturController::class, 'absensiStore'])->name('absensi.store');
        
        Route::get('/nilai', [InstrukturController::class, 'nilaiIndex'])->name('nilai.index');
        Route::post('/nilai', [InstrukturController::class, 'nilaiStore'])->name('nilai.store');
    });
});

require __DIR__.'/auth.php';