<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kehadiran Selama PKL') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                
                <div class="mb-4 text-sm text-gray-600 border-l-4 border-yellow-400 pl-3">
                    <p><strong>Informasi:</strong> Data absensi ini diisi dan diverifikasi langsung secara harian oleh Instruktur Lapangan di tempat industri. Siswa hanya dapat memantau rekapan.</p>
                </div>

                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Hari / Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jam Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jam Pulang</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($absensis as $absen)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d F Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $absen->jam_masuk ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $absen->jam_pulang ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($absen->status === 'Hadir')
                                        <span class="text-green-600 font-bold">✔ Hadir</span>
                                    @elseif($absen->status === 'Sakit' || $absen->status === 'Izin')
                                        <span class="text-yellow-600 font-bold">ℹ {{ $absen->status }}</span>
                                    @else
                                        <span class="text-red-600 font-bold">❌ {{ $absen->status ?? 'Alpha' }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500">Belum ada rekapan absensi dari Instruktur.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>