<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lembar Observasi: ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Input Observasi Baru</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif

                <form action="{{ route('guru.observasi.store', $siswa->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block font-bold mb-1">Tanggal Kunjungan/Observasi</label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div class="col-span-2">
                            <label class="block font-bold mb-1">Permasalahan yang dialami</label>
                            <textarea name="permasalahan" rows="3" class="w-full border-gray-300 rounded" placeholder="Kondisi siswa, iduka, atau kompetensi..." required></textarea>
                        </div>
                        <div class="col-span-2">
                            <label class="block font-bold mb-1">Solusi / Pemecahan Masalah</label>
                            <textarea name="solusi" rows="3" class="w-full border-gray-300 rounded" required></textarea>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-6 rounded">Kirim Observasi</button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Riwayat Observasi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">Tanggal</th>
                                <th class="border p-2 w-1/3">Permasalahan</th>
                                <th class="border p-2 w-1/3">Solusi</th>
                                <th class="border p-2">Status Instruktur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($observasis as $obs)
                            <tr class="text-sm">
                                <td class="border p-2">{{ \Carbon\Carbon::parse($obs->tanggal)->format('d M Y') }}</td>
                                <td class="border p-2">{{ $obs->permasalahan }}</td>
                                <td class="border p-2">{{ $obs->solusi }}</td>
                                <td class="border p-2">
                                    <span class="font-bold uppercase">{{ $obs->status_persetujuan }}</span>
                                    @if($obs->catatan_instruktur)
                                        <p class="text-gray-500 mt-1 italic">"{{ $obs->catatan_instruktur }}"</p>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="border p-2 text-center">Belum ada data observasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>