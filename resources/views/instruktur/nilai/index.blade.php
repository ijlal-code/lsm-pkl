<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Penilaian Akhir PKL</h2></x-slot>

    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8"><div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div> @endif

        <table class="w-full text-left border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Siswa</th>
                    <th class="border p-2 text-center" colspan="4">Kriteria Nilai (1 - 5)</th>
                    <th class="border p-2">Catatan Instruktur</th>
                    <th class="border p-2 text-center">Aksi</th>
                </tr>
                <tr class="bg-gray-50 text-xs">
                    <th class="border p-2"></th>
                    <th class="border p-2 text-center">Soft Skills</th>
                    <th class="border p-2 text-center">Hard Skills</th>
                    <th class="border p-2 text-center">Pengembangan</th>
                    <th class="border p-2 text-center">Kewirausahaan</th>
                    <th class="border p-2"></th>
                    <th class="border p-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswas as $siswa)
                @php $n = $nilais->get($siswa->id); @endphp
                <tr>
                    <form action="{{ route('instruktur.nilai.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                        <td class="border p-2 font-bold">{{ $siswa->name }}</td>
                        <td class="border p-2 text-center"><input type="number" name="soft_skills" min="1" max="5" value="{{ $n->soft_skills ?? '' }}" class="w-16 border-gray-300 rounded" required></td>
                        <td class="border p-2 text-center"><input type="number" name="hard_skills" min="1" max="5" value="{{ $n->hard_skills ?? '' }}" class="w-16 border-gray-300 rounded" required></td>
                        <td class="border p-2 text-center"><input type="number" name="pengembangan" min="1" max="5" value="{{ $n->pengembangan ?? '' }}" class="w-16 border-gray-300 rounded" required></td>
                        <td class="border p-2 text-center"><input type="number" name="kewirausahaan" min="1" max="5" value="{{ $n->kewirausahaan ?? '' }}" class="w-16 border-gray-300 rounded" required></td>
                        <td class="border p-2"><textarea name="catatan_tambahan" rows="1" class="w-full border-gray-300 rounded text-sm">{{ $n->catatan_tambahan ?? '' }}</textarea></td>
                        <td class="border p-2 text-center"><button type="submit" class="bg-blue-600 text-white py-1 px-3 rounded text-sm hover:bg-blue-800">Simpan</button></td>
                    </form>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div></div></div>
</x-app-layout>