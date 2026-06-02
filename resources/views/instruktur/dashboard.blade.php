<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Instruktur Industri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700">Total Siswa Bimbingan Industri</h3>
                        <p class="text-4xl font-bold mt-2 text-blue-600">{{ $totalSiswa }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700">Jurnal Menunggu Persetujuan</h3>
                        <p class="text-4xl font-bold mt-2 text-orange-600">{{ $jurnalMenunggu }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Tugas Instruktur Harian</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('instruktur.jurnal.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Validasi Jurnal Siswa</a>
                        <a href="{{ route('instruktur.absensi.index') }}" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">Isi Daftar Hadir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>