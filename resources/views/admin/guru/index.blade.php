<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-lg text-gray-800 leading-tight">Data Guru Pembimbing</h2></x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Dashboard</a>

            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border-l-4 border-green-500">
                <h3 class="text-lg font-bold mb-4">Tambah Guru</h3>
                @if(session('success')) <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-sm">{{ session('success') }}</div> @endif
                <form action="{{ route('admin.guru.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama Guru" class="border-gray-300 rounded text-sm w-full" required>
                    <input type="email" name="email" placeholder="Email Akun" class="border-gray-300 rounded text-sm w-full" required>
                    <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700 text-sm">Tambah</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <div class="overflow-x-auto border border-gray-100 rounded-lg">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 text-xs text-gray-600 border-b">
                            <tr><th class="p-3">Nama</th><th class="p-3">Email</th><th class="p-3 text-center">Aksi</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($gurus as $guru)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-bold">{{ $guru->name }}</td>
                                <td class="p-3 text-gray-600">{{ $guru->email }}</td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Hapus guru?');">@csrf @method('DELETE')<button class="text-red-500 font-bold text-xs hover:underline">Hapus</button></form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>