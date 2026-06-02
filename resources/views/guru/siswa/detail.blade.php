<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Detail: ') }} {{ $siswa->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Jurnal & Catatan Kegiatan Siswa</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase">Pekerjaan & Pelaksanaan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase">Persetujuan Industri</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-blue-800 uppercase">Berikan Feedback Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($jurnals as $jurnal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <span class="font-bold block">{{ $jurnal->nama_pekerjaan }}</span>
                                <p class="text-xs text-gray-600 mt-1 line-clamp-3">{{ $jurnal->pelaksanaan }}</p>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full {{ $jurnal->status_persetujuan === 'Disetujui' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $jurnal->status_persetujuan }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <form action="{{ route('guru.jurnal.feedback', $jurnal->id) }}" method="POST" class="flex flex-col space-y-2">
                                    @csrf @method('PUT')
                                    <textarea name="feedback_guru" class="text-xs border-gray-300 rounded focus:border-blue-500 w-full" rows="2" placeholder="Tuliskan evaluasi/feedback disini..." required>{{ $jurnal->feedback_guru }}</textarea>
                                    <button type="submit" class="bg-blue-600 text-white text-xs px-3 py-1 rounded shadow hover:bg-blue-700 w-fit">Simpan Feedback</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Siswa belum mengunggah jurnal apapun.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-white shadow sm:rounded-lg overflow-x-auto">
                <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Rekap Daftar Hadir Industri</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jam Masuk</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Jam Pulang</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($absensis as $absen)
                        <tr>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $absen->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $absen->jam_pulang ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm font-bold {{ $absen->status === 'Hadir' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $absen->status }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada absensi yang diinput oleh industri.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>