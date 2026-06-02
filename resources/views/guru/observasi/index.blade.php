<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lembar Observasi PKL Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-600 border-l-4 border-indigo-500 pl-3">
                    <p><strong>Informasi:</strong> Lembar observasi ini diisi oleh Guru Pembimbing saat melakukan kunjungan lapangan atau evaluasi bulanan terhadap siswa di tempat PKL.</p>
                </div>

                <div class="space-y-8 mt-6">
                    @forelse($siswas as $siswa)
                    @php $obs = $observasis[$siswa->id] ?? null; @endphp
                    <div class="border rounded-md p-4 bg-gray-50">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{ $siswa->name }}</h4>
                                <span class="text-sm text-orange-600 font-medium">{{ $siswa->perusahaan->nama_perusahaan ?? 'Belum ada industri' }}</span>
                            </div>
                            @if($obs)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">Sudah Diobservasi</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-bold">Belum Diobservasi</span>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('guru.observasi.store', $siswa->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div>
                                <x-input-label value="Tanggal Observasi / Kunjungan" />
                                <x-text-input name="tanggal_observasi" type="date" value="{{ $obs->tanggal ?? \Carbon\Carbon::now()->format('Y-m-d') }}" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label value="Penilaian Aspek Sikap (A/B/C/D)" />
                                <select name="nilai_sikap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Nilai --</option>
                                    <option value="Sangat Baik (A)" {{ ($obs->aspek_sikap ?? '') == 'Sangat Baik (A)' ? 'selected' : '' }}>Sangat Baik (A)</option>
                                    <option value="Baik (B)" {{ ($obs->aspek_sikap ?? '') == 'Baik (B)' ? 'selected' : '' }}>Baik (B)</option>
                                    <option value="Cukup (C)" {{ ($obs->aspek_sikap ?? '') == 'Cukup (C)' ? 'selected' : '' }}>Cukup (C)</option>
                                    <option value="Kurang (D)" {{ ($obs->aspek_sikap ?? '') == 'Kurang (D)' ? 'selected' : '' }}>Kurang (D)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label value="Penilaian Aspek Keterampilan Kerja" />
                                <select name="nilai_keterampilan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Nilai --</option>
                                    <option value="Sangat Baik (A)" {{ ($obs->aspek_keterampilan ?? '') == 'Sangat Baik (A)' ? 'selected' : '' }}>Sangat Baik (A)</option>
                                    <option value="Baik (B)" {{ ($obs->aspek_keterampilan ?? '') == 'Baik (B)' ? 'selected' : '' }}>Baik (B)</option>
                                    <option value="Cukup (C)" {{ ($obs->aspek_keterampilan ?? '') == 'Cukup (C)' ? 'selected' : '' }}>Cukup (C)</option>
                                    <option value="Kurang (D)" {{ ($obs->aspek_keterampilan ?? '') == 'Kurang (D)' ? 'selected' : '' }}>Kurang (D)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label value="Catatan / Evaluasi Lapangan" />
                                <x-text-input name="catatan_observasi" type="text" value="{{ $obs->catatan ?? '' }}" class="mt-1 block w-full" placeholder="Masukkan catatan temuan..." />
                            </div>
                            <div class="md:col-span-2">
                                <x-primary-button>Simpan Hasil Observasi</x-primary-button>
                            </div>
                        </form>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">Belum ada siswa bimbingan.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>