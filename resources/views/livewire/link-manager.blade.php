<div>
    @if (session()->has('linkSuccess'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
            {{ session('linkSuccess') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            
            <h3 class="font-bold text-lg mb-4">
                {{ $linkIdBeingEdited ? 'Edit Link' : 'Tambah Link Baru' }}
            </h3>
            
            <form wire:submit.prevent="saveLink">
                <div class="flex flex-col gap-4" wire:key="form-input-{{ $iteration }}">
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        
                        <div class="w-full sm:w-auto">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Ikon/Gbr (Opsional)</label>
                            <input type="file" wire:model="photo" id="upload-{{ $iteration }}" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">
                            @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Judul</label>
                            <input type="text" wire:model="title" placeholder="Judul Link" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input type="url" wire:model="url" placeholder="URL (https://...)" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex gap-2">
                            @if($linkIdBeingEdited)
                                <button type="button" wire:click="cancelEdit" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                                    Batal
                                </button>
                            @endif

                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50 transition">
                                <span wire:loading.remove wire:target="saveLink">
                                    {{ $linkIdBeingEdited ? 'Update' : 'Tambah' }}
                                </span>
                                <span wire:loading wire:target="saveLink">Processing...</span>
                            </button>
                        </div>
                    </div>

                    @if ($photo)
                        <div class="text-xs text-green-600">
                            Preview: <img src="{{ $photo->temporaryUrl() }}" class="w-10 h-10 object-cover rounded mt-1">
                        </div>
                    @endif

                </div>
            </form>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="font-bold text-lg mb-4">Link Aktif (Geser untuk Mengurutkan)</h3>

            <ul id="link-list" class="space-y-3">
                @foreach($links as $link)
                    <li wire:key="link-{{ $link->id }}" data-id="{{ $link->id }}" class="bg-gray-50 border rounded-lg p-3 flex items-center justify-between hover:bg-white transition cursor-move group">
                        
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 cursor-move handle">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            </div>
                            
                            @if($link->thumbnail)
                                <img src="{{ asset('storage/' . $link->thumbnail) }}" class="w-10 h-10 rounded object-cover border border-gray-200">
                            @endif
                            
                            <div>
                                <h4 class="font-bold text-gray-800 flex items-center gap-2">
                                    {{ $link->title }}
                                    
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" title="Jumlah Klik">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        {{ $link->click_count }} klik
                                    </span>
                                </h4>
                                <a href="{{ $link->url }}" target="_blank" class="text-xs text-indigo-500 hover:underline truncate block max-w-[200px]">{{ $link->url }}</a>
                            </div>
                        </div>

                       <div class="flex items-center gap-1">
                            <button wire:click="editLink({{ $link->id }})" 
                                    class="text-blue-400 hover:text-blue-600 p-2 rounded-full hover:bg-blue-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <button wire:click="deleteLink({{ $link->id }})" 
                                    wire:confirm="Yakin hapus link ini?"
                                    class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>

            @if($links->count() === 0)
                <p class="text-center text-gray-400 py-4">Belum ada link. Tambahkan di atas.</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let el = document.getElementById('link-list');
            
            // Inisialisasi Sortable
            Sortable.create(el, {
                animation: 150,
                handle: '.handle', // Hanya bisa digeser jika pegang icon garis
                ghostClass: 'bg-indigo-50', // Efek visual saat digeser
                
                // Saat selesai drop/geser
                onEnd: function (evt) {
                    // Ambil urutan baru
                    let sortable = this;
                    let items = sortable.toArray(); // Array ID Link (berdasarkan data-id)
                    
                    // Format data agar sesuai selera controller Livewire
                    // Kita butuh: [{value: 1, order: 1}, {value: 5, order: 2}, ...]
                    let newOrder = items.map((value, index) => {
                        return { value: value, order: index + 1 };
                    });

                    // Panggil fungsi PHP 'updateLinkOrder' di LinkManager.php
                    @this.call('updateLinkOrder', newOrder);
                }
            });
        });
    </script>
</div>