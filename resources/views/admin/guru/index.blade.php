<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Akun Guru Pembimbing</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="p-6 bg-white shadow sm:rounded-lg">
            <h3 class="text-lg font-medium mb-4">Tambah Guru Baru</h3>
            <form method="POST" action="{{ route('admin.guru.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <div><x-input-label value="Nama Guru" /><x-text-input name="name" class="mt-1 block w-full" required /></div>
                <div><x-input-label value="Email" /><x-text-input name="email" type="email" class="mt-1 block w-full" required /></div>
                <div><x-input-label value="Password" /><x-text-input name="password" type="password" class="mt-1 block w-full" required /></div>
                <div class="md:col-span-3"><x-primary-button>Simpan Guru</x-primary-button></div>
            </form>
        </div>

        <div class="p-6 bg-white shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr><th>Nama</th><th>Email</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($gurus as $guru)
                    <tr class="text-center">
                        <td class="py-2">{{ $guru->name }}</td>
                        <td>{{ $guru->email }}</td>
                        <td>
                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus Guru?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>