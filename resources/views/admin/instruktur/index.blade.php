<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mengelola Data Industri & Instruktur Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pendaftaran Hubungan Kerja Industri & Instruktur Lapangan</h3>
                <form method="POST" action="{{ route('admin.instruktur.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div class="md:col-span-2 bg-gray-50 p-3 rounded font-bold text-sm text-gray-700">A. DATA PERUSAHAAN / INDUSTRI</div>
                    <div>
                        <x-input-label value="Nama Instansi Perusahaan" />
                        <x-text-input name="nama_perusahaan" type="text" class="mt-1 block w-full" placeholder="Contoh: PT. Studio Komputer Mandiri" required />
                    </div>
                    <div>
                        <x-input-label value="Alamat Kantor Industri" />
                        <x-text-input name="alamat" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div class="md:col-span-2 bg-gray-50 p-3 rounded font-bold text-sm text-gray-700 mt-2">B. DATA AKUN INSTRUKTUR LAPANGAN (PENYETUJU JURNAL)</div>
                    <div>
                        <x-input-label value="Nama Lengkap Instruktur Lapangan" />
                        <x-text-input name="name" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Email Akun Instruktur" />
                        <x-text-input name="email" type="email" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Password Akses Instruktur" />
                        <x-text-input name="password" type="password" class="mt-1 block w-full" required />
                    </div>
                    
                    <div class="md:col-span-2 mt-2">
                        <x-primary-button>Daftarkan Kerja Sama Industri</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Kerja Sama Industri & Instruktur Terverifikasi</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Instruktur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Instansi Industri</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($instrukturs as $ins)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $ins->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $ins->email }}</td>
                            <td class="px-6 py-4 text-sm text-orange-600 font-bold">{{ $ins->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('admin.instruktur.destroy', $ins->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus seluruh kemitraan industri ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>