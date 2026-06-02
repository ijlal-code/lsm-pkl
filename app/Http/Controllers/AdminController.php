<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function dashboard()
    {
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        $jumlahInstruktur = User::where('role', 'instruktur')->count();
        $jumlahIndustri = Perusahaan::count();

        return view('admin.dashboard', compact('jumlahSiswa', 'jumlahGuru', 'jumlahInstruktur', 'jumlahIndustri'));
    }

    // ==========================================
    // 1. LOGIKA MANAJEMEN SISWA PKL
    // ==========================================
    public function siswaIndex()
    {
        $siswas = User::where('role', 'siswa')->with(['guru', 'perusahaan'])->latest()->get();
        $gurus = User::where('role', 'guru')->get();
        $perusahaans = Perusahaan::all();
        return view('admin.siswa.index', compact('siswas', 'gurus', 'perusahaans'));
    }

    public function siswaStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max::255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'guru_id' => ['nullable', 'exists:users,id'],
            'perusahaan_id' => ['nullable', 'exists:perusahaans,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'guru_id' => $request->guru_id,
            'perusahaan_id' => $request->perusahaan_id,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function siswaUpdate(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$siswa->id],
            'guru_id' => ['nullable', 'exists:users,id'],
            'perusahaan_id' => ['nullable', 'exists:perusahaans,id'],
        ]);

        $siswa->name = $request->name;
        $siswa->email = $request->email;
        $siswa->guru_id = $request->guru_id;
        $siswa->perusahaan_id = $request->perusahaan_id;

        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }

        $siswa->save();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function siswaDestroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    // ==========================================
    // 2. LOGIKA MANAJEMEN GURU PEMBIMBING
    // ==========================================
    public function guruIndex()
    {
        $gurus = User::where('role', 'guru')->latest()->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function guruStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru pembimbing berhasil didaftarkan!');
    }

    public function guruUpdate(Request $request, $id)
    {
        $guru = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$guru->id],
        ]);

        $guru->name = $request->name;
        $guru->email = $request->email;
        if ($request->filled('password')) {
            $guru->password = Hash::make($request->password);
        }
        $guru->save();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function guruDestroy($id)
    {
        $guru = User::findOrFail($id);
        // Lepas relasi bimbingan siswa sebelum dihapus agar tidak crash
        User::where('guru_id', $id)->update(['guru_id' => null]);
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Akun guru berhasil dihapus!');
    }

    // ==========================================
    // 3. LOGIKA MANAJEMEN MITRA INDUSTRI & INSTRUKTUR
    // ==========================================
    public function instrukturIndex()
    {
        $instrukturs = User::where('role', 'instruktur')->with('perusahaan')->latest()->get();
        $perusahaans = Perusahaan::all();
        return view('admin.instruktur.index', compact('instrukturs', 'perusahaans'));
    }

    public function instrukturStore(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        // 1. Simpan/buat data Industri terlebih dahulu
        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
        ]);

        // 2. Simpan data akun Instruktur terkait industri tersebut
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'instruktur',
            'perusahaan_id' => $perusahaan->id,
        ]);

        return redirect()->route('admin.instruktur.index')->with('success', 'Data Industri & Instruktur Berhasil Terintegrasi!');
    }

    public function instrukturUpdate(Request $request, $id)
    {
        $instruktur = User::findOrFail($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$instruktur->id],
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
        ]);

        $instruktur->name = $request->name;
        $instruktur->email = $request->email;
        if ($request->filled('password')) {
            $instruktur->password = Hash::make($request->password);
        }
        $instruktur->save();

        if ($instruktur->perusahaan_id) {
            $perusahaan = Perusahaan::find($instruktur->perusahaan_id);
            if ($perusahaan) {
                $perusahaan->update([
                    'nama_perusahaan' => $request->nama_perusahaan,
                    'alamat' => $request->alamat,
                ]);
            }
        }

        return redirect()->route('admin.instruktur.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function instrukturDestroy($id)
    {
        $instruktur = User::findOrFail($id);
        if ($instruktur->perusahaan_id) {
            // Hapus juga data perusahan mitranya
            Perusahaan::where('id', $instruktur->perusahaan_id)->delete();
            User::where('perusahaan_id', $instruktur->perusahaan_id)->update(['perusahaan_id' => null]);
        }
        $instruktur->delete();

        return redirect()->route('admin.instruktur.index')->with('success', 'Data Mitra Industri Berhasil Dihapus!');
    }

    // ==========================================
    // 4. LOGIKA PENGATURAN PERIODE & PEDOMAN PKL
    // ==========================================
    public function pengaturanIndex()
    {
        $pengaturan = Pengaturan::first();
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function pengaturanUpdate(Request $request)
    {
        $request->validate([
            'nama_periode' => ['required', 'string', 'max:255'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'panduan_laporan' => ['nullable', 'string'],
        ]);

        $pengaturan = Pengaturan::first();
        if (!$pengaturan) {
            $pengaturan = new Pengaturan();
        }

        $pengaturan->nama_periode = $request->nama_periode;
        $pengaturan->tanggal_mulai = $request->tanggal_mulai;
        $pengaturan->tanggal_selesai = $request->tanggal_selesai;
        $pengaturan->panduan_laporan = $request->panduan_laporan;
        $pengaturan->save();

        return redirect()->route('admin.pengaturan.index')->with('success', 'Konfigurasi Periode & Panduan PKL Berhasil Diperbarui!');
    }
}