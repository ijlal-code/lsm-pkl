<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Jurnal & Kegiatan Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nama Siswa</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Kegiatan / Pekerjaan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Aksi Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($jurnals as $jurnal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ $jurnal->siswa->name ?? 'Anonim' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <strong>{{ $jurnal->nama_pekerjaan }}</strong><br>
                                <p class="text-xs mt-1 text-gray-500 whitespace-pre-wrap max-w-xs">{{ $jurnal->pelaksanaan }}</p>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                @if($jurnal->status_persetujuan === 'Disetujui')
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm">
                                @if($jurnal->status_persetujuan !== 'Disetujui')
                                <form action="{{ route('instruktur.jurnal.setujui', $jurnal->id) }}" method="POST" class="flex flex-col space-y-2">
                                    @csrf @method('PUT')
                                    <textarea name="catatan_instruktur" class="text-xs border-gray-300 rounded p-1 w-full" rows="2" placeholder="Catatan/Saran tambahan..."></textarea>
                                    <button type="submit" class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700" onclick="return confirm('Setujui jurnal ini?')">✔ Setujui Jurnal</button>
                                </form>
                                @else
                                    <span class="text-gray-500 italic text-xs">Telah disetujui</span>
                                    @if($jurnal->catatan_instruktur)
                                    <p class="text-xs text-blue-600 mt-1">"{{ $jurnal->catatan_instruktur }}"</p>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada jurnal dari siswa di industri ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>