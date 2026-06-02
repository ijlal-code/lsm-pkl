<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mengisi Daftar Hadir Siswa PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form Pengisian Absen -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Input Kehadiran Harian</h3>
                <form method="POST" action="{{ route('instruktur.absensi.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    @csrf
                    <div>
                        <x-input-label value="Nama Siswa" />
                        <select name="siswa_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label value="Tanggal Kehadiran" />
                        <x-text-input name="tanggal" type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Status Kehadiran" />
                        <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label value="Jam Masuk (HH:mm)" />
                        <x-text-input name="jam_masuk" type="time" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label value="Jam Pulang (HH:mm - Opsional)" />
                        <x-text-input name="jam_pulang" type="time" class="mt-1 block w-full" />
                    </div>
                    <div>
                        <x-primary-button class="w-full justify-center">Simpan Absensi</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Absensi -->
            <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Daftar Hadir Industri</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Pulang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($riwayatAbsensi as $absen)
                        <tr>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $absen->siswa->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d F Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $absen->jam_masuk ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $absen->jam_pulang ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($absen->status === 'Hadir')
                                    <span class="text-green-600 font-bold">Hadir</span>
                                @elseif($absen->status === 'Alpha')
                                    <span class="text-red-600 font-bold">Alpha</span>
                                @else
                                    <span class="text-yellow-600 font-bold">{{ $absen->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-sm">Belum ada data absensi diinputkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</x-app-layout>