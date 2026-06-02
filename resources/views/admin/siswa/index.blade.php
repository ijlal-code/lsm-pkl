<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-lg text-gray-800 leading-tight">Data Siswa & Mapping Penempatan</h2></x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Dashboard Admin</a>

            <!-- Form Tambah Siswa -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-indigo-500">
                <h3 class="text-lg font-bold mb-4">Tambah Siswa PKL Baru</h3>
                @if(session('success')) <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-sm">{{ session('success') }}</div> @endif
                <form action="{{ route('admin.siswa.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Lengkap" class="border-gray-300 rounded text-sm w-full" required>
                    <input type="email" name="email" placeholder="Email Siswa" class="border-gray-300 rounded text-sm w-full" required>
                    <input type="text" name="kelas" placeholder="Kelas (ex: XI)" class="border-gray-300 rounded text-sm w-full">
                    <input type="text" name="jurusan" placeholder="Jurusan" class="border-gray-300 rounded text-sm w-full">
                    <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 text-sm whitespace-nowrap">Tambah</button>
                </form>
            </div>

            <!-- Tabel Mapping -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <div class="overflow-x-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap min-w-max">
                        <thead class="bg-gray-50 uppercase text-xs text-gray-600 border-b">
                            <tr><th class="p-3">Siswa</th><th class="p-3">Kls/Jrsn</th><th class="p-3 w-1/2">Mapping Relasi (Industri / Instruktur / Guru)</th><th class="p-3 text-center">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($siswas as $siswa)
                            <tr class="hover:bg-gray-50">
                                <form action="{{ route('admin.siswa.mapping', $siswa->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <td class="p-3 font-bold">{{ $siswa->name }}<br><span class="text-xs text-gray-500">{{ $siswa->email }}</span></td>
                                    <td class="p-3"><input type="text" name="kelas" value="{{ $siswa->kelas }}" class="w-16 border-gray-300 rounded text-xs p-1 mb-1 block"><input type="text" name="jurusan" value="{{ $siswa->jurusan }}" class="w-24 border-gray-300 rounded text-xs p-1 block"></td>
                                    <td class="p-3 space-y-1">
                                        <select name="perusahaan_id" class="w-full border-gray-300 rounded text-xs p-1 block"><option value="">- Tempat Industri -</option>@foreach($perusahaans as $p) <option value="{{ $p->id }}" {{ $siswa->perusahaan_id == $p->id ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option> @endforeach</select>
                                        <select name="instruktur_id" class="w-full border-gray-300 rounded text-xs p-1 block"><option value="">- Instruktur Industri -</option>@foreach($instrukturs as $i) <option value="{{ $i->id }}" {{ $siswa->instruktur_id == $i->id ? 'selected' : '' }}>{{ $i->name }}</option> @endforeach</select>
                                        <select name="guru_id" class="w-full border-gray-300 rounded text-xs p-1 block"><option value="">- Guru Pembimbing -</option>@foreach($gurus as $g) <option value="{{ $g->id }}" {{ $siswa->guru_id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option> @endforeach</select>
                                    </td>
                                    <td class="p-3 text-center flex flex-col gap-1 mt-3">
                                        <button type="submit" class="bg-blue-600 text-white p-1.5 rounded text-xs w-full hover:bg-blue-700">Simpan</button>
                                    </td>
                                </form>
                                <td class="p-3 align-top pt-6">
                                    <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?');">@csrf @method('DELETE')<button class="bg-red-100 text-red-700 border border-red-200 p-1.5 rounded text-xs w-full hover:bg-red-200">Hapus</button></form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>