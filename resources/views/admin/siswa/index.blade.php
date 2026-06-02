<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah / Edit Data Siswa</h3>
                    
                    <form method="POST" action="{{ route('admin.siswa.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="name" value="Nama Lengkap Siswa" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password (Isi jika siswa baru)" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                        </div>

                        <div>
                            <x-input-label for="guru_id" value="Plotting Guru Pembimbing" />
                            <select id="guru_id" name="guru_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Guru Pembimbing --</option>
                                {{-- Loop data guru dari controller --}}
                                @foreach($gurus ?? [] as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="perusahaan_id" value="Plotting Tempat Industri (Perusahaan)" />
                            <select id="perusahaan_id" name="perusahaan_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Perusahaan --</option>
                                {{-- Loop data perusahaan dari controller --}}
                                @foreach($perusahaans ?? [] as $perusahaan)
                                    <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Data Siswa') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Siswa Terdaftar</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guru Pembimbing</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Industri / Tempat PKL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($siswas as $siswa)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $siswa->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $siswa->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $siswa->guru->name ?? 'Belum Di-plotting' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $siswa->perusahaan->nama_perusahaan ?? 'Belum Di-plotting' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus siswa ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data siswa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>