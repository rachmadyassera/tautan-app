<div>
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            <h3 class="font-bold text-lg mb-4">Tambah Link Baru</h3>
            
            <form wire:submit.prevent="saveLink">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <input type="text" wire:model="title" placeholder="Judul (misal: WhatsApp)" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1">
                        <input type="url" wire:model="url" placeholder="URL (https://...)" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50">
                        <span wire:loading.remove wire:target="saveLink">Tambah</span>
                        <span wire:loading wire:target="saveLink">Menyimpan...</span>
                    </button>
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
                            
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $link->title }}</h4>
                                <a href="{{ $link->url }}" target="_blank" class="text-xs text-indigo-500 hover:underline truncate block max-w-[200px]">{{ $link->url }}</a>
                            </div>
                        </div>

                        <button wire:click="deleteLink({{ $link->id }})" 
                                wire:confirm="Yakin hapus link ini?"
                                class="text-red-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
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