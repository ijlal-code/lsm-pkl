<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700">Total Jurnal Dikirim</h3>
                        <p class="text-4xl font-bold mt-2 text-blue-600">{{ $totalJurnal }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700">Total Kehadiran Aktif</h3>
                        <p class="text-4xl font-bold mt-2 text-green-600">{{ $totalHadir }} Hari</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Akses Cepat Siswa</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('siswa.jurnal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Tulis Jurnal Hari Ini</a>
                        <a href="{{ route('siswa.absensi.index') }}" class="bg-gray-100 text-gray-800 border px-4 py-2 rounded shadow hover:bg-gray-200">Cek Rekap Absensi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>