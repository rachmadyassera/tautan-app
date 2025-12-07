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
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Ups! Ada masalah:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
                                    <div class="mb-6 text-center border-b pb-6">
                                        <p class="text-sm font-bold text-gray-700 mb-3">QR Code Anda</p>
                                        
                                        <div class="flex justify-center mb-3">
                                            <div class="p-3 bg-white border rounded-lg shadow-sm inline-block">
                                                {!! QrCode::size(120)->color(79, 70, 229)->generate(route('public.page', $page->slug)) !!}
                                            </div>
                                        </div>

                                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ route('public.page', $page->slug) }}" 
                                        target="_blank" download
                                        class="text-xs text-indigo-600 hover:text-indigo-800 font-bold underline">
                                            Download QR
                                        </a>
                                    </div>
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
                                    @error('avatar')
                                        <p class="text-red-500 text-sm mt-2 font-bold bg-red-50 p-2 rounded">
                                            {{ $message }}
                                        </p>
                                    @enderror
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

                                <div class="mb-6">
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Pilih Tema Tampilan</label>
                                    
                                    <div class="grid grid-cols-3 gap-3">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme" value="default" class="peer sr-only" {{ $page->theme == 'default' ? 'checked' : '' }}>
                                            <div class="h-16 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500"></div>
                                            <span class="text-xs text-center block mt-1 text-gray-600">Colorful</span>
                                        </label>

                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme" value="dark" class="peer sr-only" {{ $page->theme == 'dark' ? 'checked' : '' }}>
                                            <div class="h-16 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 bg-gray-900"></div>
                                            <span class="text-xs text-center block mt-1 text-gray-600">Dark Mode</span>
                                        </label>

                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme" value="ocean" class="peer sr-only" {{ $page->theme == 'ocean' ? 'checked' : '' }}>
                                            <div class="h-16 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 bg-gradient-to-b from-blue-400 to-cyan-300"></div>
                                            <span class="text-xs text-center block mt-1 text-gray-600">Ocean</span>
                                        </label>
                                        
                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme" value="sunset" class="peer sr-only" {{ $page->theme == 'sunset' ? 'checked' : '' }}>
                                            <div class="h-16 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 bg-gradient-to-tr from-orange-400 to-red-500"></div>
                                            <span class="text-xs text-center block mt-1 text-gray-600">Sunset</span>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme" value="forest" class="peer sr-only" {{ $page->theme == 'forest' ? 'checked' : '' }}>
                                            <div class="h-16 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 bg-gradient-to-br from-emerald-500 to-teal-600"></div>
                                            <span class="text-xs text-center block mt-1 text-gray-600">Forest</span>
                                        </label>

                                        <label class="cursor-pointer">
                                            <input type="radio" name="theme" value="luxury" class="peer sr-only" {{ $page->theme == 'luxury' ? 'checked' : '' }}>
                                            <div class="h-16 rounded-lg border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-indigo-200 bg-black border-b-4 border-b-yellow-500"></div>
                                            <span class="text-xs text-center block mt-1 text-gray-600">Luxury</span>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                                    Simpan Profil
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <livewire:link-manager />
                </div>
            </div>

        </div>
    </div>
</x-app-layout>