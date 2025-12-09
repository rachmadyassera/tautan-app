<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-4 border-b gap-4" 
             x-data="{ showQr: false, copied: false }">
            
            <div>
                <h3 class="font-bold text-lg text-gray-800">Edit Profil & Tampilan</h3>
                <p class="text-xs text-gray-500">Atur identitas, tema, dan bagikan profil Anda.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                
                @php
                    $publicUrl = route('public.page', Auth::user()->page->slug);
                @endphp
                <a href="{{ $publicUrl }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-200 focus:outline-none transition disabled:opacity-25">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat
                </a>

                <button type="button" 
                        @click="navigator.clipboard.writeText('{{ $publicUrl }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none transition relative">
                    
                    <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                    
                    <svg x-show="copied" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    
                    <span x-text="copied ? 'Disalin!' : 'Salin'">Salin</span>
                </button>

                <button type="button" @click="showQr = !showQr"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-50 border border-indigo-200 rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest shadow-sm hover:bg-indigo-100 focus:outline-none transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h6v6H6V6zm1.5 1.5v3h3v-3h-3zm6.5.5h6v6h-6V8zm1.5 1.5v3h3v-3h-3zM6 15h6v6H6v-6zm1.5 1.5v3h3v-3h-3z"></path></svg>
                    QR Code
                </button>

            </div>

            <div x-show="showQr" style="display: none;" 
                 @click.away="showQr = false"
                 class="absolute top-20 right-6 z-50 bg-white p-4 rounded-xl shadow-2xl border border-gray-100 flex flex-col items-center animate-fade-in-down">
                
                <h4 class="text-sm font-bold text-gray-600 mb-3">Scan untuk Kunjungi</h4>
                
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $publicUrl }}" 
                     alt="QR Code" class="rounded-lg border p-1 mb-3">
                
                <button @click="showQr = false" class="text-xs text-red-500 hover:underline">Tutup</button>
            </div>

        </div>
        @if (session()->has('settingsSuccess'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('settingsSuccess') }}
            </div>
        @endif

        <form wire:submit.prevent="saveSettings">
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-4">
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" class="w-16 h-16 rounded-full object-cover border-2 border-indigo-500">
                            @elseif ($existingAvatar)
                                <img src="{{ asset('storage/' . $existingAvatar) }}" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </div>
                            @endif
                            
                            <input type="file" wire:model="avatar" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        @error('avatar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Username (URL)</label>
                        <div class="flex w-full rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 overflow-hidden">
                            <span class="flex select-none items-center pl-3 pr-2 text-gray-500 sm:text-sm bg-gray-100 border-r border-gray-300">
                                {{ request()->getHost() }}/
                            </span>
                            <input type="text" wire:model="slug" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="username">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Hanya huruf, angka, dan tanda strip (-).</p>
                        @error('slug') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama / Judul Halaman</label>
                        <input type="text" wire:model="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Bio Singkat</label>
                        <textarea wire:model="bio_text" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 160 karakter.</p>
                        @error('bio_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                </div>

                <div>
                    @php
                        $themes = [
                            'default' => ['label' => 'Default (Colorful)', 'color' => 'bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500'],
                            'dark'    => ['label' => 'Dark Mode', 'color' => 'bg-gray-800'],
                            'ocean'   => ['label' => 'Ocean Blue', 'color' => 'bg-gradient-to-b from-sky-400 to-blue-600'],
                            'sunset'  => ['label' => 'Sunset Orange', 'color' => 'bg-gradient-to-tr from-orange-500 to-red-600'],
                            'forest'  => ['label' => 'Forest Green', 'color' => 'bg-gradient-to-br from-emerald-600 to-teal-900'],
                            'luxury'  => ['label' => 'Luxury Gold', 'color' => 'bg-neutral-900 border border-yellow-600'],
                        ];
                    @endphp
                    <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Tema Warna</label>
                    
                    <div class="grid grid-cols-2 gap-3 mb-8">
                        @foreach($themes as $key => $val)
                            <label class="cursor-pointer relative" wire:key="theme-{{ $key }}">
                                <input type="radio" wire:model="theme" name="theme" value="{{ $key }}" class="peer sr-only">
                                <div class="p-3 rounded-lg border-2 hover:bg-gray-50 transition-all peer-checked:border-indigo-600 peer-checked:bg-indigo-50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full shadow-sm {{ $val['color'] }}"></div>
                                        <span class="text-sm font-medium text-gray-700">{{ $val['label'] }}</span>
                                    </div>
                                </div>
                                <div class="absolute top-1 right-2 hidden peer-checked:block text-indigo-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <div class="pt-6 border-t border-gray-200">
                        <label class="block text-sm font-bold text-gray-700 mb-4">Tautkan Sosial Media</label>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                            
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </div>
                                <input type="url" wire:model="soc_instagram" 
                                    class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pink-500 sm:text-sm sm:leading-6 transition" 
                                    placeholder="https://instagram.com/username">
                            </div>

                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                </div>
                                <input type="url" wire:model="soc_tiktok" 
                                    class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6 transition" 
                                    placeholder="https://tiktok.com/@username">
                            </div>

                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                </div>
                                <input type="url" wire:model="soc_whatsapp" 
                                    class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-500 sm:text-sm sm:leading-6 transition" 
                                    placeholder="https://wa.me/62...">
                            </div>
                            
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </div>
                                <input type="url" wire:model="soc_youtube" 
                                    class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-red-600 sm:text-sm sm:leading-6 transition" 
                                    placeholder="https://youtube.com/channel/...">
                            </div>

                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                                </div>
                                <input type="url" wire:model="soc_facebook" 
                                    class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 transition" 
                                    placeholder="https://facebook.com/username">
                            </div>

                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                                </div>
                                <input type="url" wire:model="soc_twitter" 
                                    class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6 transition" 
                                    placeholder="https://x.com/username">
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="mt-8 text-right border-t pt-4">
                <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-lg hover:bg-black transition shadow-lg">
                    <span wire:loading.remove wire:target="saveSettings">Simpan Perubahan</span>
                    <span wire:loading wire:target="saveSettings">Menyimpan...</span>
                </button>
            </div>

        </form>
    </div>
</div>