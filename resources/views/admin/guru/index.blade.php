<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mengelola Data Guru Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Guru Pembimbing Baru</h3>
                <form method="POST" action="{{ route('admin.guru.store') }}" class="space-y-4 max-w-xl">
                    @csrf
                    <div>
                        <x-input-label value="Nama Lengkap Guru (Beserta Gelar)" />
                        <x-text-input name="name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Email Instansi/Aktif" />
                        <x-text-input name="email" type="email" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Password Akun" />
                        <x-text-input name="password" type="password" class="mt-1 block w-full" required />
                    </div>
                    <x-primary-button>Simpan Data Guru</x-primary-button>
                </form>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Guru Pembimbing Aktif</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($gurus as $guru)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $guru->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $guru->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus akun guru ini?')">Hapus Akun</button>
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