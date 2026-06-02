<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-lg text-gray-800 leading-tight">Pengaturan Sistem & Dokumen PDF</h2></x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Dashboard</a>

            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-t-4 border-gray-800">
                <p class="text-sm text-gray-600 mb-4">Data di bawah ini digunakan sebagai atribut *Header* (Kop) pada saat Guru atau Instruktur mencetak dokumen Lembar Nilai PDF.</p>
                
                @if(session('success')) <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-sm">{{ session('success') }}</div> @endif
                
                <form action="{{ route('admin.pengaturan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Sekolah</label>
                        <input type="text" name="pengaturan[nama_sekolah]" value="{{ $pengaturan['nama_sekolah'] ?? 'UPTD SMKN 1 MAJENE' }}" class="w-full border-gray-300 rounded text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tahun Pelajaran</label>
                        <input type="text" name="pengaturan[tahun_pelajaran]" value="{{ $pengaturan['tahun_pelajaran'] ?? '2025/2026' }}" class="w-full border-gray-300 rounded text-sm" required>
                    </div>
                    <button type="submit" class="bg-gray-800 text-white font-bold py-2 px-6 rounded-lg hover:bg-gray-900 text-sm w-full sm:w-auto">Simpan Pengaturan</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>