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
                        <label class="block text-sm font-bold text-gray-700 mb-3">Tautkan Sosial Media</label>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">IG</span>
                                <input type="url" wire:model="soc_instagram" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="https://instagram.com/...">
                            </div>

                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">TT</span>
                                <input type="url" wire:model="soc_tiktok" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="https://tiktok.com/...">
                            </div>

                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">WA</span>
                                <input type="url" wire:model="soc_whatsapp" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="https://wa.me/62...">
                            </div>
                            
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">YT</span>
                                <input type="url" wire:model="soc_youtube" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="https://youtube.com/...">
                            </div>

                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">FB</span>
                                <input type="url" wire:model="soc_facebook" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="https://facebook.com/...">
                            </div>

                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">X</span>
                                <input type="url" wire:model="soc_twitter" class="block flex-1 border-0 bg-transparent py-2 pl-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="https://x.com/...">
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