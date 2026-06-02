<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Koordinator PKL SMK N 1 Majene') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <!-- Rekap Siswa -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <h3 class="text-lg font-bold">Total Siswa PKL</h3>
                        <p class="text-4xl mt-2 text-blue-600">{{ $countSiswa }}</p>
                    </div>
                </div>
                <!-- Rekap Guru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <h3 class="text-lg font-bold">Total Guru Pembimbing</h3>
                        <p class="text-4xl mt-2 text-green-600">{{ $countGuru }}</p>
                    </div>
                </div>
                <!-- Rekap Instruktur -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        <h3 class="text-lg font-bold">Total Instruktur Industri</h3>
                        <p class="text-4xl mt-2 text-orange-600">{{ $countInstruktur }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Menu Kelola Akses Cepat</h3>
                    <ul class="list-disc pl-5">
                        <li><a href="{{ route('admin.siswa.index') }}" class="text-blue-500 hover:underline">Kelola Data Siswa PKL</a></li>
                        <li><a href="{{ route('admin.guru.index') }}" class="text-blue-500 hover:underline">Kelola Data Guru Pembimbing</a></li>
                        <li><a href="{{ route('admin.instruktur.index') }}" class="text-blue-500 hover:underline">Kelola Data Instruktur/Industri</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>