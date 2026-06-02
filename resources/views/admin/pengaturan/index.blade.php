<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mengatur Periode Pelaksanaan & Panduan Umum PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 bg-white shadow sm:rounded-lg max-w-2xl">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Konfigurasi Validasi Kalender Akademik PKL</h3>
                
                <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label value="Nama Gelombang / Periode PKL Aktif" />
                        <x-text-input name="nama_periode" type="text" class="mt-1 block w-full" value="{{ $pengaturan->nama_periode ?? '' }}" placeholder="Contoh: Periode Ganjil Gelombang I Angkatan 2026" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Tanggal Mulai Pelaksanaan" />
                            <x-text-input name="tanggal_mulai" type="date" class="mt-1 block w-full" value="{{ $pengaturan->tanggal_mulai ?? '' }}" required />
                        </div>
                        <div>
                            <x-input-label value="Tanggal Penarikan Siswa" />
                            <x-text-input name="tanggal_selesai" type="date" class="mt-1 block w-full" value="{{ $pengaturan->tanggal_selesai ?? '' }}" required />
                        </div>
                    </div>

                    <div>
                        <x-input-label value="Sistematika Laporan PKL (Akan Ditampilkan Pada Siswa)" />
                        <textarea name="panduan_laporan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="6" placeholder="Masukkan struktur bab laporan PKL sekolah disini...">{{ $pengaturan->panduan_laporan ?? '' }}</textarea>
                    </div>

                    <x-primary-button>Simpan & Terapkan Konfigurasi</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>