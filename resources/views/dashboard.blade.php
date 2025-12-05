<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Tambah Link Baru</h3>
                    
                    <form action="{{ route('links.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Judul Tombol</label>
                                <input type="text" name="title" placeholder="Contoh: WhatsApp Saya" 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            
                            <div>
                                <label class="block font-medium text-sm text-gray-700">URL Tujuan</label>
                                <input type="url" name="url" placeholder="https://wa.me/..." 
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div class="mt-4 text-right">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                + Simpan Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Link Aktif Saya</h3>

                    @if($links->count() > 0)
                        <div class="space-y-4">
                            @foreach($links as $link)
                                <div class="flex items-center justify-between p-4 border rounded-lg bg-gray-50">
                                    <div>
                                        <h4 class="font-bold">{{ $link->title }}</h4>
                                        <p class="text-sm text-gray-500 truncate">{{ $link->url }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <form action="{{ route('links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Belum ada link. Yuk tambahkan satu!</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>