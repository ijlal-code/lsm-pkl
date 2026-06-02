<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mengelola Data Siswa PKL & Plotting Bimbingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Registrasi & Penempatan Siswa Baru</h3>
                <form method="POST" action="{{ route('admin.siswa.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <x-input-label for="name" value="Nama Lengkap Siswa" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email Akun" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="password" value="Password Default Akun" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="guru_id" value="Plotting Guru Pembimbing" />
                        <select id="guru_id" name="guru_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Guru --</option>
                            {{-- Menggunakan forelse agar tahu jika database guru kosong --}}
                            @forelse($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @empty
                                <option value="" disabled>⚠️ Data guru kosong, silakan tambah Guru terlebih dahulu!</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="perusahaan_id" value="Plotting Tempat Industri / Perusahaan" />
                        <select id="perusahaan_id" name="perusahaan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Perusahaan Mitra --</option>
                            {{-- Menggunakan forelse agar tahu jika database perusahaan kosong --}}
                            @forelse($perusahaans as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_perusahaan }}</option>
                            @empty
                                <option value="" disabled>⚠️ Data perusahaan kosong, silakan tambah Industri terlebih dahulu!</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <x-primary-button>Simpan & Daftarkan Siswa</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Aktif Monitoring Siswa</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guru Pembimbing</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tempat Industri</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($siswas as $siswa)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $siswa->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $siswa->email }}</td>
                            <td class="px-4 py-3 text-sm text-blue-600 font-medium">{{ $siswa->guru->name ?? 'Belum Di-plotting' }}</td>
                            <td class="px-4 py-3 text-sm text-orange-600 font-medium">{{ $siswa->perusahaan->nama_perusahaan ?? 'Belum Di-plotting' }}</td>
                            <td class="px-4 py-3 text-sm space-x-2">
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus siswa ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>