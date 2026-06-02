<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Isi Jurnal & Catatan Kegiatan Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('siswa.jurnal.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="text-sm font-bold text-blue-800">Bagian 1: Data Jurnal Kegiatan Utama</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Hari / Tanggal Kegiatan" />
                            <x-text-input name="tanggal" type="date" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label value="Unit Kerja / Divisi Pekerjaan" />
                            <x-text-input name="unit_kerja" type="text" class="mt-1 block w-full" placeholder="Contoh: Divisi IT Support" required />
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-6 mb-4">
                        <p class="text-sm font-bold text-blue-800">Bagian 2: Detail Catatan Pekerjaan</p>
                    </div>

                    <div>
                        <x-input-label value="Nama Pekerjaan (Topik Utama)" />
                        <x-text-input name="nama_pekerjaan" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <x-input-label value="Perencanaan Kegiatan (Jadwal/Target)" />
                        <textarea name="perencanaan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3" required></textarea>
                    </div>

                    <div>
                        <x-input-label value="Pelaksanaan Kegiatan / Hasil Kerja" />
                        <textarea name="pelaksanaan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4" required></textarea>
                    </div>

                    <div>
                        <x-input-label value="Upload Dokumentasi (Opsional - Foto Kegiatan)" />
                        <input type="file" name="dokumentasi" accept="image/*" class="mt-1 block w-full border border-gray-300 p-2 rounded-md">
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>Kirim Jurnal Harian</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>