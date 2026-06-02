<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Industri & Instruktur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Mitra Industri & Instruktur</h3>
                    
                    <form method="POST" action="{{ route('admin.instruktur.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="nama_perusahaan" value="Nama Perusahaan / Dunia Kerja" />
                            <x-text-input id="nama_perusahaan" name="nama_perusahaan" type="text" class="mt-1 block w-full" placeholder="Contoh: PT. Majene Media Kreatif" required />
                        </div>

                        <div>
                            <x-input-label for="alamat_perusahaan" value="Alamat Perusahaan" />
                            <textarea id="alamat_perusahaan" name="alamat_perusahaan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="2"></textarea>
                        </div>

                        <hr class="my-4 border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700">Akun Instruktur Lapangan</h4>

                        <div>
                            <x-input-label for="name" value="Nama Lengkap Instruktur" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email Instruktur" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Daftarkan Hubungan Kerja') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Mitra Perusahaan & Instruktur Terdaftar</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Instruktur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Perusahaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($instrukturs as $instruktur)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $instruktur->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $instruktur->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $instruktur->perusahaan->nama_perusahaan ?? 'Perusahaan belum ditautkan' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <form action="{{ route('admin.instruktur.destroy', $instruktur->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus data instruktur ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada mitra industri terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>