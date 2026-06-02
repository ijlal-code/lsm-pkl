<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-lg text-gray-800 leading-tight">Data Industri & Instruktur</h2></x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Dashboard</a>
            @if(session('success')) <div class="bg-green-100 text-green-700 p-2 rounded text-sm">{{ session('success') }}</div> @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Kelola Perusahaan -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                    <h3 class="text-lg font-bold mb-4 text-orange-600 border-b pb-2">1. Daftar Tempat PKL (DUDI)</h3>
                    <form action="{{ route('admin.perusahaan.store') }}" method="POST" class="flex gap-2 mb-4">
                        @csrf
                        <input type="text" name="nama_perusahaan" placeholder="Nama Perusahaan..." class="border-gray-300 rounded text-sm w-full" required>
                        <button type="submit" class="bg-orange-500 text-white font-bold py-2 px-3 rounded text-sm">+</button>
                    </form>
                    <div class="overflow-x-auto border border-gray-100 rounded-lg max-h-64 overflow-y-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap"><thead class="bg-gray-50 text-xs text-gray-600 sticky top-0"><tr><th class="p-2">Nama DUDI</th><th class="p-2 text-right">Aksi</th></tr></thead><tbody class="divide-y divide-gray-100">
                            @foreach($perusahaans as $p)
                            <tr><td class="p-2 font-bold">{{ $p->nama_perusahaan }}</td><td class="p-2 text-right"><form action="{{ route('admin.perusahaan.destroy', $p->id) }}" method="POST">@csrf @method('DELETE')<button class="text-red-500 text-xs hover:underline">Hapus</button></form></td></tr>
                            @endforeach
                        </tbody></table>
                    </div>
                </div>

                <!-- Kelola Akun Instruktur -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                    <h3 class="text-lg font-bold mb-4 text-purple-600 border-b pb-2">2. Akun Instruktur Pembimbing</h3>
                    <form action="{{ route('admin.instruktur.store') }}" method="POST" class="flex gap-2 mb-4">
                        @csrf
                        <input type="text" name="name" placeholder="Nama" class="border-gray-300 rounded text-sm w-full" required>
                        <input type="email" name="email" placeholder="Email" class="border-gray-300 rounded text-sm w-full" required>
                        <button type="submit" class="bg-purple-600 text-white font-bold py-2 px-3 rounded text-sm">+</button>
                    </form>
                    <div class="overflow-x-auto border border-gray-100 rounded-lg max-h-64 overflow-y-auto">
                        <table class="w-full text-left text-sm whitespace-nowrap"><thead class="bg-gray-50 text-xs text-gray-600 sticky top-0"><tr><th class="p-2">Nama Instruktur</th><th class="p-2 text-right">Aksi</th></tr></thead><tbody class="divide-y divide-gray-100">
                            @foreach($instrukturs as $i)
                            <tr><td class="p-2 font-bold">{{ $i->name }}<br><span class="text-xs font-normal text-gray-500">{{ $i->email }}</span></td><td class="p-2 text-right"><form action="{{ route('admin.instruktur.destroy', $i->id) }}" method="POST">@csrf @method('DELETE')<button class="text-red-500 text-xs hover:underline">Hapus</button></form></td></tr>
                            @endforeach
                        </tbody></table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>