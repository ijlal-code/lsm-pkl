<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Periode & Informasi PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg max-w-2xl">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Konfigurasi Sistem Gelombang PKL</h3>
                
                <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nama_periode" value="Nama Periode Akademik PKL" />
                        <x-text-input id="nama_periode" name="nama_periode" type="text" class="mt-1 block w-full" value="{{ $pengaturan->nama_periode ?? '' }}" placeholder="Contoh: PKL Semester Ganjil 2026/2027" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="tanggal_mulai" value="Tanggal Mulai Pelaksanaan" />
                            <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" value="{{ $pengaturan->tanggal_mulai ?? '' }}" required />
                        </div>
                        <div>
                            <x-input-label for="tanggal_selesai" value="Tanggal Selesai Penarikan" />
                            <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" value="{{ $pengaturan->tanggal_selesai ?? '' }}" required />
                        </div>
                    </div>

                    <hr class="border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700">Panduan Pengisian Dokumen / Laporan (Untuk Siswa)</h4>

                    <div>
                        <x-input-label for="panduan_laporan" value="Format Sistematika Penulisan Laporan" />
                        <textarea id="panduan_laporan" name="panduan_laporan" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5" placeholder="Tuliskan petunjuk penyusunan laporan PKL di sini...">{{ $pengaturan->panduan_laporan ?? '' }}</textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Perbarui Konfigurasi PKL') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>