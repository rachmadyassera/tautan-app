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

            <div class="px-6 text-center -mt-20 relative z-10 pb-6">
                
                <div class="relative mx-auto w-32 h-32 rounded-full overflow-hidden border-[6px] border-white shadow-xl mb-3 bg-white">
                    @if(str_starts_with($page->avatar_path, 'http'))
                        <img src="{{ $page->avatar_path }}" alt="{{ $page->title }}" class="object-cover w-full h-full">
                    @else
                        <img src="{{ asset('storage/' . $page->avatar_path) }}" alt="{{ $page->title }}" class="object-cover w-full h-full">
                    @endif
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

        <div class="flex-1 px-6 pt-6 pb-12 space-y-4 overflow-y-auto custom-scrollbar">
            @foreach($links as $link)
                <a href="{{ route('link.visit', $link->short_code) }}" 
                   target="_blank"  
                   class="block w-full py-4 px-6 text-center font-bold border-2 rounded-xl transition-all transform hover:-translate-y-1 shadow-sm
                        {{ $currentTheme['btn_bg'] }} 
                        {{ $currentTheme['btn_text'] }} 
                        {{ $currentTheme['btn_border'] }}">
                   
                   <span class="flex items-center justify-center relative">
                        {{ $link->title }}
                        
                        <svg class="w-4 h-4 absolute right-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                   </span>
                </a>
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