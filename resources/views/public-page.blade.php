@php
    // Definisikan Library Tema (Mapping Warna)
    $themes = [
        'default' => [
            'bg_body' => 'bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500',
            'bg_card' => 'bg-white',
            'text_primary' => 'text-gray-900',
            'text_secondary' => 'text-gray-500',
            'banner' => 'bg-gradient-to-r from-purple-500 to-pink-500',
            'btn_bg' => 'bg-white hover:bg-gray-50',
            'btn_text' => 'text-gray-800 hover:text-indigo-600',
            'btn_border' => 'border-gray-200 hover:border-indigo-500',
            'footer' => 'text-white' // Karena bg-nya colorful, footer harus putih biar kontras
        ],
        'dark' => [
            'bg_body' => 'bg-gray-900', // Luar kartu hitam pekat
            'bg_card' => 'bg-gray-800', // Kartu abu gelap
            'text_primary' => 'text-white',
            'text_secondary' => 'text-gray-400',
            'banner' => 'bg-gradient-to-r from-gray-700 to-gray-600',
            'btn_bg' => 'bg-gray-700 hover:bg-gray-600',
            'btn_text' => 'text-white',
            'btn_border' => 'border-gray-600',
            'footer' => 'text-gray-500'
        ],
        'ocean' => [
            'bg_body' => 'bg-gradient-to-b from-sky-400 to-blue-600',
            'bg_card' => 'bg-white',
            'text_primary' => 'text-slate-800',
            'text_secondary' => 'text-slate-500',
            'banner' => 'bg-gradient-to-r from-sky-300 to-blue-400',
            'btn_bg' => 'bg-white hover:bg-sky-50',
            'btn_text' => 'text-sky-700',
            'btn_border' => 'border-sky-200 hover:border-sky-500',
            'footer' => 'text-white'
        ],
        'sunset' => [
            'bg_body' => 'bg-gradient-to-tr from-orange-500 to-red-600',
            'bg_card' => 'bg-orange-50',
            'text_primary' => 'text-red-900',
            'text_secondary' => 'text-red-400',
            'banner' => 'bg-gradient-to-r from-orange-300 to-red-400',
            'btn_bg' => 'bg-white hover:bg-orange-100',
            'btn_text' => 'text-red-800',
            'btn_border' => 'border-orange-200 hover:border-red-400',
            'footer' => 'text-white'
        ],
        'forest' => [
            'bg_body' => 'bg-gradient-to-br from-emerald-600 to-teal-900',
            'bg_card' => 'bg-emerald-50',
            'text_primary' => 'text-emerald-900',
            'text_secondary' => 'text-emerald-600',
            'banner' => 'bg-gradient-to-r from-emerald-400 to-teal-500',
            'btn_bg' => 'bg-white hover:bg-emerald-100',
            'btn_text' => 'text-emerald-700',
            'btn_border' => 'border-emerald-200 hover:border-emerald-500',
            'footer' => 'text-emerald-100'
        ],
        // TEMA 5: FOREST (Hijau Alam)
        'forest' => [
            'bg_body' => 'bg-gradient-to-br from-emerald-600 to-teal-900',
            'bg_card' => 'bg-emerald-50',
            'text_primary' => 'text-emerald-900',
            'text_secondary' => 'text-emerald-600',
            'banner' => 'bg-gradient-to-r from-emerald-400 to-teal-500',
            'btn_bg' => 'bg-white hover:bg-emerald-100',
            'btn_text' => 'text-emerald-700',
            'btn_border' => 'border-emerald-200 hover:border-emerald-500',
            'footer' => 'text-emerald-100'
        ],

        // TEMA 6: LUXURY (Hitam & Emas)
        'luxury' => [
            'bg_body' => 'bg-neutral-900', // Background sangat gelap
            'bg_card' => 'bg-black border border-yellow-600/30', // Kartu hitam dengan garis emas tipis
            'text_primary' => 'text-yellow-500', // Teks Emas
            'text_secondary' => 'text-yellow-200/70', // Teks Emas pudar
            'banner' => 'bg-gradient-to-r from-yellow-700 via-yellow-500 to-yellow-600', // Gradasi Emas
            'btn_bg' => 'bg-neutral-900 hover:bg-neutral-800',
            'btn_text' => 'text-yellow-500 hover:text-yellow-300',
            'btn_border' => 'border-yellow-700 hover:border-yellow-400',
            'footer' => 'text-gray-500'
        ],
    ];

    // Ambil tema dari database, kalau tidak ada/salah pakai 'default'
    $currentTheme = $themes[$page->theme] ?? $themes['default'];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }}</title>
    <meta name="description" content="{{ $page->bio_text ?? 'Kunjungi link bio saya.' }}">
    <meta name="author" content="{{ $page->title }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('public.page', $page->slug) }}">
    <meta property="og:title" content="{{ $page->title }}">
    <meta property="og:description" content="{{ $page->bio_text ?? 'Lihat profil dan link lengkap saya di sini.' }}">
    <meta property="og:image" content="{{ str_starts_with($page->avatar_path, 'http') ? $page->avatar_path : asset('storage/' . $page->avatar_path) }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page->title }}">
    <meta name="twitter:description" content="{{ $page->bio_text ?? 'Lihat profil dan link lengkap saya di sini.' }}">
    <meta name="twitter:image" content="{{ str_starts_with($page->avatar_path, 'http') ? $page->avatar_path : asset('storage/' . $page->avatar_path) }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex items-center justify-center p-0 sm:p-4 {{ $currentTheme['bg_body'] }}">

    <div class="w-full min-h-screen relative overflow-hidden flex flex-col 
            sm:max-w-md sm:min-h-0 sm:rounded-[2rem] sm:shadow-2xl 
            sm:max-h-[90vh] sm:h-auto
            {{ $currentTheme['bg_card'] }}">
        
        <div class="relative w-full">
    
            <div class="h-40 w-full {{ $currentTheme['banner'] }}"></div>

            <div class="px-6 text-center -mt-20 relative z-10 pb-1">
                
                <div class="relative mx-auto w-32 h-32 rounded-full overflow-hidden border-[6px] border-white shadow-xl mb-3 bg-white">
                    <img src="{{ $page->avatar_url }}" alt="{{ $page->title }}" class="object-cover w-full h-full">
                </div>

                <h1 class="text-2xl font-bold mb-1 {{ $currentTheme['text_primary'] }}">
                    {{ $page->title }}
                </h1>
                
                @if($page->bio_text)
                    <p class="text-sm max-w-xs mx-auto {{ $currentTheme['text_secondary'] }}">
                        {{ $page->bio_text }}
                    </p>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap justify-center gap-4 mt-4 mb-2">
    
            {{-- Helper CSS agar ikon berubah warna sesuai tema --}}
            @php $iconClass = "w-6 h-6 fill-current opacity-80 hover:opacity-100 transition hover:scale-110 " . $currentTheme['text_primary']; @endphp

            @if($page->soc_instagram)
            <a href="{{ $page->soc_instagram }}" target="_blank">
                <svg class="{{ $iconClass }}" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            @endif

            @if($page->soc_tiktok)
            <a href="{{ $page->soc_tiktok }}" target="_blank">
                <svg class="{{ $iconClass }}" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
            </a>
            @endif

            @if($page->soc_whatsapp)
            <a href="{{ $page->soc_whatsapp }}" target="_blank">
                <svg class="{{ $iconClass }}" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
            </a>
            @endif

            @if($page->soc_youtube)
            <a href="{{ $page->soc_youtube }}" target="_blank">
                <svg class="{{ $iconClass }}" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
            </a>
            @endif

            @if($page->soc_facebook)
            <a href="{{ $page->soc_facebook }}" target="_blank">
                <svg class="{{ $iconClass }}" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
            </a>
            @endif

            @if($page->soc_twitter)
            <a href="{{ $page->soc_twitter }}" target="_blank">
                <svg class="{{ $iconClass }}" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
            </a>
            @endif

        </div>

        <div class="flex-1 px-6 pt-3 pb-12 space-y-4 overflow-y-auto custom-scrollbar">
            @foreach($links as $link)
    
                {{-- LOGIKA: Cek apakah ini HEADER atau LINK BIASA? --}}
                
                @if($link->is_header)
                    {{-- TAMPILAN HEADER (Judul Bagian) --}}
                    <div class="w-full text-center py-4 mt-2 mb-1 relative">
                        <h3 class="font-bold text-lg tracking-wide uppercase opacity-90 {{ $currentTheme['text_primary'] }}">
                            {{ $link->title }}
                        </h3>
                        {{-- Garis tipis opsional di bawah header --}}
                        <div class="w-16 h-0.5 mx-auto bg-current opacity-20 rounded mt-1 {{ $currentTheme['text_primary'] }}"></div>
                    </div>

                @else
                    {{-- TAMPILAN LINK BIASA (Tombol) --}}
                    <a href="{{ route('link.visit', $link->short_code) }}" 
                    target="_blank"  
                    class="relative block w-full py-4 rounded-xl transition-all transform hover:-translate-y-1 shadow-sm mb-3 border-2 group
                            {{ $currentTheme['btn_bg'] }} 
                            {{ $currentTheme['btn_text'] }} 
                            {{ $currentTheme['btn_border'] }}">
                    
                        {{-- 1. GAMBAR (Posisi Absolute di Kiri) --}}
                        @if($link->thumbnail)
                            <img src="{{ asset('storage/' . $link->thumbnail) }}" 
                                alt="Icon" 
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm">
                        @endif

                        {{-- 2. TEXT (Padding Kiri Kanan agar aman) --}}
                        <div class="w-full text-center px-14">
                            <span class="font-bold block truncate">{{ $link->title }}</span>
                        </div>
                    </a>
                @endif

            @endforeach

            @if($links->count() == 0)
                <div class="text-center text-gray-400 text-sm py-8 border-2 border-dashed border-gray-200 rounded-xl">
                    Belum ada link.
                </div>
            @endif
        </div>

        <div class="py-4 text-center text-xs border-t border-transparent sm:border-gray-100 opacity-80 {{ $currentTheme['text_secondary'] }}">
            <p>Dibuat dengan <span class="font-bold text-indigo-500">Tautan App</span></p>
        </div>

    </div>

</body>
</html>