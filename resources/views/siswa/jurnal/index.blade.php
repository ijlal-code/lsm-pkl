<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Jurnal & Feedback Pembimbing') }}
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
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Pekerjaan</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Status Instruktur</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Catatan Instruktur</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Feedback Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($jurnals as $jurnal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-sm text-gray-900 whitespace-nowrap">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-sm text-gray-900">
                                <strong>{{ $jurnal->unit_kerja }}</strong><br>
                                <span class="text-xs text-gray-500">{{ $jurnal->nama_pekerjaan }}</span>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                @if($jurnal->status_persetujuan === 'Disetujui')
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Disetujui</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $jurnal->catatan_instruktur ?? '-' }}</td>
                            <td class="px-4 py-4 text-sm text-blue-700 font-medium bg-blue-50/50">{{ $jurnal->feedback_guru ?? 'Belum ada evaluasi' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada jurnal yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>