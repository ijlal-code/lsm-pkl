<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">Dashboard Siswa</h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h3 class="text-xl sm:text-2xl font-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-gray-500 text-sm sm:text-base mb-6">Kelola aktivitas magang industri Anda di sini.</p>
                
                <div class="grid grid-cols-2 gap-3 sm:gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-3 sm:p-4 border border-blue-100 text-center">
                        <p class="text-xs text-blue-600 font-bold uppercase">Total Jurnal</p>
                        <h4 class="text-2xl sm:text-4xl font-black text-blue-800">{{ $jumlahJurnal }}</h4>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 sm:p-4 border border-green-100 text-center">
                        <p class="text-xs text-green-600 font-bold uppercase">Disetujui</p>
                        <h4 class="text-2xl sm:text-4xl font-black text-green-800">{{ $jurnalDisetujui }}</h4>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('siswa.jurnal.index') }}" class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-indigo-400 hover:shadow transition block text-center">
                        <div class="text-3xl mb-2">📝</div>
                        <h5 class="text-lg font-bold text-gray-900">Jurnal Harian</h5>
                        <p class="text-xs text-gray-500 mt-1">Isi & pantau jurnal kegiatan</p>
                    </a>
                    <a href="{{ route('siswa.dokumen.index') }}" class="p-4 sm:p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-indigo-400 hover:shadow transition block text-center">
                        <div class="text-3xl mb-2">📁</div>
                        <h5 class="text-lg font-bold text-gray-900">Dokumen & Nilai</h5>
                        <p class="text-xs text-gray-500 mt-1">Upload laporan & cek nilai</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>