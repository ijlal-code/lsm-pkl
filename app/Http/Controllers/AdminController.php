<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD ADMIN
    // ==========================================
    public function dashboard()
    {
        $jumlahSiswa = User::where('role', 'siswa_pkl')->count();
        $jumlahGuru = User::where('role', 'guru_pembimbing')->count();
        $jumlahInstruktur = User::where('role', 'instruktur_industri')->count();
        $jumlahPerusahaan = Perusahaan::count();
        return view('admin.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahInstruktur', 'jumlahPerusahaan'));
    }

    // ==========================================
    // KELOLA SISWA & MAPPING
    // ==========================================
    public function siswaIndex()
    {
        $siswas = User::where('role', 'siswa_pkl')->get();
        $gurus = User::where('role', 'guru_pembimbing')->get();
        $instrukturs = User::where('role', 'instruktur_industri')->get();
        $perusahaans = Perusahaan::all();
        return view('admin.siswa.index', compact('siswas', 'gurus', 'instrukturs', 'perusahaans'));
    }

    public function siswaStore(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users']);
        User::create([
            'name' => $request->name, 'email' => $request->email, 
            'password' => Hash::make('password123'), 'role' => 'siswa_pkl',
            'kelas' => $request->kelas, 'jurusan' => $request->jurusan
        ]);
        return redirect()->back()->with('success', 'Akun Siswa berhasil ditambahkan! (Password default: password123)');
    }

    public function updateMapping(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        $siswa->update($request->only(['kelas', 'jurusan', 'perusahaan_id', 'instruktur_id', 'guru_id']));
        return redirect()->back()->with('success', 'Mapping siswa berhasil disimpan!');
    }

    public function siswaDestroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }

    // ==========================================
    // KELOLA GURU PEMBIMBING
    // ==========================================
    public function guruIndex()
    {
        $gurus = User::where('role', 'guru_pembimbing')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function guruStore(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users']);
        User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make('password123'), 'role' => 'guru_pembimbing']);
        return redirect()->back()->with('success', 'Akun Guru ditambahkan! (Password: password123)');
    }

    public function guruDestroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Akun Guru dihapus.');
    }

    // ==========================================
    // KELOLA INSTRUKTUR & PERUSAHAAN
    // ==========================================
    public function instrukturIndex()
    {
        $instrukturs = User::where('role', 'instruktur_industri')->get();
        $perusahaans = Perusahaan::all();
        return view('admin.instruktur.index', compact('instrukturs', 'perusahaans'));
    }

    public function instrukturStore(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:users']);
        User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make('password123'), 'role' => 'instruktur_industri']);
        return redirect()->back()->with('success', 'Akun Instruktur ditambahkan!');
    }

    public function instrukturDestroy($id) { User::findOrFail($id)->delete(); return redirect()->back()->with('success', 'Akun dihapus.'); }

    public function perusahaanStore(Request $request)
    {
        $request->validate(['nama_perusahaan' => 'required']);
        Perusahaan::create($request->only(['nama_perusahaan', 'alamat']));
        return redirect()->back()->with('success', 'Tempat Industri ditambahkan!');
    }

    public function perusahaanDestroy($id) { Perusahaan::findOrFail($id)->delete(); return redirect()->back()->with('success', 'Industri dihapus.'); }

    // ==========================================
    // PENGATURAN SISTEM (UNTUK PDF)
    // ==========================================
    public function pengaturanIndex()
    {
        $pengaturan = Pengaturan::pluck('nilai', 'kunci')->toArray();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function pengaturanStore(Request $request)
    {
        foreach ($request->pengaturan as $kunci => $nilai) {
            Pengaturan::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
        }
        return redirect()->back()->with('success', 'Pengaturan sistem berhasil disimpan!');
    }
}