<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('public.page', $page->slug) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900 font-bold underline">
                Lihat Halaman Saya &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1 shadow-lg">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-bold text-lg mb-4 border-b pb-2">Edit Profil</h3>
                            
                            <form action="{{ route('page.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4 text-center">
                                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-gray-200 mb-2">
                                        @if(str_starts_with($page->avatar_path, 'http'))
                                            <img src="{{ $page->avatar_path }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('storage/' . $page->avatar_path) }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700 cursor-pointer text-indigo-600 hover:text-indigo-800">
                                        <span>Ganti Foto</span>
                                        <input type="file" name="avatar" class="hidden" onchange="this.form.submit()">
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <label class="block font-medium text-sm text-gray-700 mb-1">Username (URL)</label>
                                    <div class="flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                            {{ request()->getHost() }}/
                                        </span>
                                        <input type="text" name="slug" value="{{ old('slug', $page->slug) }}" 
                                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="username-anda">
                                    </div>
                                    @error('slug')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-400 mt-1">Gunakan huruf, angka, atau tanda strip (-).</p>
                                </div>

                                <div class="mb-4">
                                    <label class="block font-medium text-sm text-gray-700">Nama / Judul</label>
                                    <input type="text" name="title" value="{{ old('title', $page->title) }}" 
                                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block font-medium text-sm text-gray-700">Bio Singkat</label>
                                    <textarea name="bio_text" rows="3" 
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('bio_text', $page->bio_text) }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                                    Simpan Profil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg ">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-bold text-lg mb-4">Tambah Link Baru</h3>
                            <form action="{{ route('links.store') }}" method="POST">
                                @csrf
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <input type="text" name="title" placeholder="Judul (misal: WhatsApp)" class="flex-1 border-gray-300 rounded-md shadow-sm" required>
                                    <input type="url" name="url" placeholder="URL (https://...)" class="flex-1 border-gray-300 rounded-md shadow-sm" required>
                                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="font-bold text-lg mb-4">Link Aktif</h3>
                            @if($links->count() > 0)
                                <div class="space-y-3">
                                    @foreach($links as $link)
                                        <div class="flex items-center justify-between p-3 border rounded-lg bg-gray-50 hover:bg-white transition">
                                            <div class="flex items-center gap-3">
                                                <div class="cursor-move text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-800">{{ $link->title }}</h4>
                                                    <a href="{{ $link->url }}" target="_blank" class="text-xs text-indigo-500 hover:underline">{{ $link->url }}</a>
                                                </div>
                                            </div>
                                            
                                            <form action="{{ route('links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Hapus link ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 p-2 hover:bg-red-50 rounded-full">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400 text-center text-sm py-4">Belum ada link.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>