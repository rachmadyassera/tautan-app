<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tautanku') }} - Satu Tautan untuk Semua Link</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-figtree">

    <nav class="absolute top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold text-indigo-600 tracking-tighter">
                Tautan<span class="text-gray-900">Ku.</span>
            </a>

            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-indigo-600 transition">Masuk</a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hidden sm:inline-block px-5 py-2 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center lg:text-left flex flex-col lg:flex-row items-center">
            
            <div class="lg:w-1/2 lg:pr-10">
                <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    Satu Tautan untuk <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Semua Sosmedmu.</span>
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                    Kumpulkan TikTok, Instagram, WhatsApp, dan toko onlinemu dalam satu halaman cantik. Mudah dibuat, gratis selamanya.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold text-lg rounded-full hover:bg-indigo-700 transition shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                        Buat Tautan Sekarang &rarr;
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-gray-700 font-bold text-lg rounded-full border border-gray-200 hover:bg-gray-50 transition">
                        Pelajari Fitur
                    </a>
                </div>
                
                <div class="mt-8 flex items-center justify-center lg:justify-start space-x-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Tanpa Kartu Kredit
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setup 2 Menit
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 mt-16 lg:mt-0 relative">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                
                <div class="relative mx-auto border-gray-800 dark:border-gray-800 bg-gray-800 border-[14px] rounded-[2.5rem] h-[600px] w-[300px] shadow-2xl flex flex-col overflow-hidden">
                    <div class="h-[32px] w-[3px] bg-gray-800 absolute -start-[17px] top-[72px] rounded-s-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[124px] rounded-s-lg"></div>
                    <div class="h-[46px] w-[3px] bg-gray-800 absolute -start-[17px] top-[178px] rounded-s-lg"></div>
                    <div class="h-[64px] w-[3px] bg-gray-800 absolute -end-[17px] top-[142px] rounded-e-lg"></div>
                    <div class="rounded-[2rem] overflow-hidden w-[272px] h-[572px] bg-white dark:bg-gray-800">
                        <iframe src="{{ url('/official-zuhri') }}" class="w-full h-full border-0" scrolling="yes"></iframe>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-12">Semua yang Anda Butuhkan</h2>
            
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 bg-gray-50 rounded-2xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Tema Kustom</h3>
                    <p class="text-gray-500">Pilih tema yang sesuai dengan brand Anda. Dari Dark Mode, Luxury, hingga Forest.</p>
                </div>

                <div class="p-8 bg-gray-50 rounded-2xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Analitik & QR</h3>
                    <p class="text-gray-500">Pantau jumlah klik link Anda dan dapatkan QR Code otomatis siap cetak.</p>
                </div>

                <div class="p-8 bg-gray-50 rounded-2xl hover:shadow-lg transition">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Mobile First</h3>
                    <p class="text-gray-500">Tampilan responsif yang terlihat sempurna di semua ukuran layar smartphone.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="text-2xl font-bold">TautanKu.</span>
                <p class="text-gray-400 text-sm mt-2">&copy; {{ date('Y') }} Tautan App. All rights reserved.</p>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-white">Privacy</a>
                <a href="#" class="text-gray-400 hover:text-white">Terms</a>
                <a href="#" class="text-gray-400 hover:text-white">Contact</a>
            </div>
        </div>
    </footer>

</body>
</html>