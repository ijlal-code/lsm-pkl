<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">Dashboard Admin</h2></x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <h3 class="text-xl sm:text-2xl font-bold mb-6">Ringkasan Sistem</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 text-center"><p class="text-[10px] sm:text-xs text-blue-600 font-bold uppercase">Siswa PKL</p><h4 class="text-2xl sm:text-4xl font-black text-blue-800">{{ $jumlahSiswa }}</h4></div>
                    <div class="bg-green-50 border border-green-100 rounded-lg p-3 text-center"><p class="text-[10px] sm:text-xs text-green-600 font-bold uppercase">Guru Pembimbing</p><h4 class="text-2xl sm:text-4xl font-black text-green-800">{{ $jumlahGuru }}</h4></div>
                    <div class="bg-purple-50 border border-purple-100 rounded-lg p-3 text-center"><p class="text-[10px] sm:text-xs text-purple-600 font-bold uppercase">Instruktur DUDI</p><h4 class="text-2xl sm:text-4xl font-black text-purple-800">{{ $jumlahInstruktur }}</h4></div>
                    <div class="bg-orange-50 border border-orange-100 rounded-lg p-3 text-center"><p class="text-[10px] sm:text-xs text-orange-600 font-bold uppercase">Tempat Industri</p><h4 class="text-2xl sm:text-4xl font-black text-orange-800">{{ $jumlahPerusahaan }}</h4></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.siswa.index') }}" class="p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-400 hover:shadow flex items-center gap-4 transition">
                        <div class="text-3xl">👨‍🎓</div>
                        <div><h5 class="font-bold text-gray-900">Kelola Siswa & Mapping</h5><p class="text-xs text-gray-500">Tambah siswa & atur penempatan.</p></div>
                    </a>
                    <a href="{{ route('admin.guru.index') }}" class="p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-400 hover:shadow flex items-center gap-4 transition">
                        <div class="text-3xl">👨‍🏫</div>
                        <div><h5 class="font-bold text-gray-900">Data Guru Pembimbing</h5><p class="text-xs text-gray-500">Kelola akun guru sekolah.</p></div>
                    </a>
                    <a href="{{ route('admin.instruktur.index') }}" class="p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-400 hover:shadow flex items-center gap-4 transition">
                        <div class="text-3xl">🏢</div>
                        <div><h5 class="font-bold text-gray-900">Data Instruktur & DUDI</h5><p class="text-xs text-gray-500">Kelola perusahaan & pembimbing industri.</p></div>
                    </a>
                    <a href="{{ route('admin.pengaturan.index') }}" class="p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-400 hover:shadow flex items-center gap-4 transition">
                        <div class="text-3xl">⚙️</div>
                        <div><h5 class="font-bold text-gray-900">Pengaturan Sistem</h5><p class="text-xs text-gray-500">Ubah atribut nama sekolah untuk PDF.</p></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>