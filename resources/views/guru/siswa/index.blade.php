<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Siswa Bimbingan PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tempat Industri</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Aksi Monitoring</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $siswa->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $siswa->email }}</td>
                            <td class="px-6 py-4 text-sm text-orange-600 font-medium">{{ $siswa->perusahaan->nama_perusahaan ?? 'Belum Di-plotting' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('guru.siswa.detail', $siswa->id) }}" class="text-blue-600 hover:underline font-bold">Lihat Detail & Jurnal ➔</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-6 text-center text-gray-500">Belum ada siswa yang di-plotting kepada Anda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>