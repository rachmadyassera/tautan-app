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
<body class="antialiased min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center">

    <div class="w-full min-h-screen bg-white relative overflow-hidden flex flex-col
                sm:max-w-md sm:min-h-0 sm:rounded-[2rem] sm:shadow-2xl sm:my-10">
        
        <div class="pt-12 pb-6 px-6 text-center z-10 relative">
            
            <div class="relative mx-auto w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-lg mb-4 transform hover:scale-105 transition duration-300">
                @if(str_starts_with($page->avatar_path, 'http'))
                    <img src="{{ $page->avatar_path }}" alt="{{ $page->title }}" class="object-cover w-full h-full">
                @else
                    <img src="{{ asset('storage/' . $page->avatar_path) }}" alt="{{ $page->title }}" class="object-cover w-full h-full">
                @endif
            </div>

            <h1 class="text-xl font-bold text-gray-900 mb-1 tracking-tight">
                {{ $page->title }}
            </h1>
            
            @if($page->bio_text)
                <p class="text-sm text-gray-500 max-w-xs mx-auto leading-relaxed">
                    {{ $page->bio_text }}
                </p>
            @endif
        </div>

        <div class="flex-1 px-6 pt-6 pb-12 space-y-4 overflow-y-auto custom-scrollbar">
            @foreach($links as $link)
                <a href="{{ route('link.visit', $link->id) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="group block w-full py-4 px-6 text-center font-semibold rounded-full transition-all duration-200 transform hover:-translate-y-1 hover:shadow-lg
                          bg-gray-50 text-gray-800 border-2 border-gray-100 
                          hover:border-indigo-500 hover:text-indigo-600 hover:bg-white">
                   
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

        <div class="pb-6 text-center text-xs text-gray-400">
            <p>Dibuat dengan <span class="font-bold text-indigo-500">Tautan App</span></p>
        </div>

    </div>

</body>
</html>