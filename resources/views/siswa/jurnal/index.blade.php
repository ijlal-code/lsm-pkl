<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-lg text-gray-800 leading-tight">Jurnal Kegiatan</h2></x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-4">
                    <a href="{{ route('siswa.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Kembali</a>
                    <a href="{{ route('siswa.jurnal.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm text-center w-full sm:w-auto transition">+ Tambah Jurnal</a>
                </div>

                @if(session('success')) <div class="bg-green-100 text-green-700 p-3 rounded-lg text-sm mb-4">{{ session('success') }}</div> @endif
                @if(session('error')) <div class="bg-red-100 text-red-700 p-3 rounded-lg text-sm mb-4">{{ session('error') }}</div> @endif

                <div class="overflow-x-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-left whitespace-nowrap sm:whitespace-normal">
                        <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                            <tr>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3 min-w-[150px]">Unit Kerja</th>
                                <th class="p-3 min-w-[200px]">Deskripsi</th>
                                <th class="p-3 text-center">Status</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($jurnals as $jurnal)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3">{{ \Carbon\Carbon::parse($jurnal->hari_tanggal)->format('d/m/Y') }}</td>
                                <td class="p-3 font-semibold">{{ $jurnal->unit_kerja }}</td>
                                <td class="p-3 whitespace-normal">
                                    <p class="text-gray-700">{{ Str::limit($jurnal->deskripsi_pekerjaan, 50) }}</p>
                                    @if($jurnal->catatan_instruktur) <p class="text-xs text-orange-600 mt-1 italic">Catatan: {{ $jurnal->catatan_instruktur }}</p> @endif
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold 
                                        {{ $jurnal->status_persetujuan == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                        ($jurnal->status_persetujuan == 'disetujui' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($jurnal->status_persetujuan) }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    @if($jurnal->status_persetujuan == 'pending')
                                        <form action="{{ route('siswa.jurnal.destroy', $jurnal->id) }}" method="POST" onsubmit="return confirm('Hapus jurnal ini?');">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700 text-xs font-bold border border-red-200 px-2 py-1 rounded">Hapus</button>
                                        </form>
                                    @else - @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="p-6 text-center text-gray-400">Belum ada jurnal.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>