<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Total Siswa</h3>
                    <p class="text-3xl mt-2">{{ $jumlahSiswa }}</p>
                </div>
                <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Guru Pembimbing</h3>
                    <p class="text-3xl mt-2">{{ $jumlahGuru }}</p>
                </div>
                <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Instruktur Industri</h3>
                    <p class="text-3xl mt-2">{{ $jumlahInstruktur }}</p>
                </div>
                <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold">Mitra Industri</h3>
                    <p class="text-3xl mt-2">{{ $jumlahIndustri }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Akses Kelola Data Master (CRUD)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.siswa.index') }}" class="block p-4 border rounded shadow hover:bg-gray-50 text-center text-blue-600 font-bold">
                        Kelola Data Siswa & Plotting
                    </a>
                    <a href="{{ route('admin.guru.index') }}" class="block p-4 border rounded shadow hover:bg-gray-50 text-center text-green-600 font-bold">
                        Kelola Akun Guru Pembimbing
                    </a>
                    <a href="{{ route('admin.instruktur.index') }}" class="block p-4 border rounded shadow hover:bg-gray-50 text-center text-yellow-600 font-bold">
                        Kelola Industri & Instruktur
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>