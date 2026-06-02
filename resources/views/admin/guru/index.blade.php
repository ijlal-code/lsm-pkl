<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Guru Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah / Edit Data Guru</h3>
                    
                    <form method="POST" action="{{ route('admin.guru.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="name" value="Nama Guru & Gelar" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email Instansi / Aktif" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password Akun Guru" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Data Guru') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Guru Pembimbing</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Guru</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Bimbingan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($gurus as $guru)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $guru->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $guru->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ \App\Models\User::where('role', 'siswa')->where('guru_id', $guru->id)->count() }} Siswa
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus akun guru ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data guru pembimbing.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>