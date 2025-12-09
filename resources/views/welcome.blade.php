<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TautanKu') }} - Satu Tautan untuk Semua</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-white text-gray-900 font-figtree">

    <nav class="w-full py-6 px-6 md:px-12 flex justify-between items-center max-w-7xl mx-auto">
        <div class="font-extrabold text-2xl text-indigo-900 tracking-tight">
            Tautan<span class="text-indigo-600">App.</span>
        </div>
        <div class="flex gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-indigo-600 transition py-2">Masuk</a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden sm:inline-block bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Daftar Gratis
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <section class="relative pt-12 pb-20 lg:pt-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="text-center lg:text-left z-10">
                <div class="inline-block px-4 py-1.5 bg-indigo-50 border border-indigo-100 rounded-full text-indigo-600 text-xs font-bold tracking-wide mb-6 uppercase">
                    ✨ Rilis Baru 2025
                </div>
                
                <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    Satu Link untuk <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Semua Sosmedmu.</span>
                </h1>
                
                <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    Kumpulkan TikTok, Instagram, WhatsApp, dan toko onlinemu dalam satu halaman cantik. Didesain khusus untuk profesional, ASN, dan konten kreator.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-700 hover:scale-105 transition shadow-xl shadow-indigo-200 flex items-center justify-center gap-2">
                        Buat Tautan Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="#faq" class="px-8 py-4 bg-white border-2 border-gray-100 text-gray-700 rounded-xl font-bold text-lg hover:border-indigo-100 hover:bg-indigo-50 transition flex items-center justify-center">
                        Pelajari Fitur
                    </a>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-100 flex flex-col sm:flex-row gap-6 justify-center lg:justify-start text-sm text-gray-500 font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Gratis Selamanya
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Setup Cuma 2 Menit
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Tanpa Kartu Kredit
                    </div>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                <div class="absolute top-0 right-40 w-[500px] h-[500px] bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                
                <img src="{{ asset('storage/mockups/hero-phone.png') }}" 
                     alt="App Preview" 
                     class="relative z-10 w-full max-w-md mx-auto drop-shadow-2xl transform hover:-rotate-2 transition duration-500"
                     onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-center p-20 bg-gray-50 rounded-xl border-dashed border-2\'>[Tempatkan Screenshot HP di sini]</div>'">
                     {{-- Catatan: Ganti src dengan path gambar HP Anda yang asli jika ada, atau biarkan placeholder --}}
            </div>
        </div>
    </section>

    <section id="faq" class="py-20 bg-gray-50">
        <div class="max-w-3xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
                <p class="text-gray-500">Hal-hal yang sering ditanyakan pengguna baru.</p>
            </div>

            <div class="space-y-4">
                <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center font-bold text-gray-800 hover:bg-gray-50 transition">
                        <span>Apakah aplikasi ini benar-benar gratis?</span>
                        <svg :class="{'rotate-180': open}" class="w-5 h-5 text-indigo-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 leading-relaxed">
                        Ya! Anda bisa membuat profil, menambahkan link tak terbatas, dan memilih tema secara gratis selamanya. Kami mendesain ini untuk membantu profesional dan UMKM berkembang.
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center font-bold text-gray-800 hover:bg-gray-50 transition">
                        <span>Bisakah saya mengganti link nanti?</span>
                        <svg :class="{'rotate-180': open}" class="w-5 h-5 text-indigo-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 leading-relaxed">
                        Tentu saja. Anda memiliki akses penuh ke Dashboard Admin di mana Anda bisa menambah, menghapus, atau mengedit urutan link kapan saja secara real-time.
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = !open" class="w-full px-6 py-4 text-left flex justify-between items-center font-bold text-gray-800 hover:bg-gray-50 transition">
                        <span>Apakah ada fitur analisis pengunjung?</span>
                        <svg :class="{'rotate-180': open}" class="w-5 h-5 text-indigo-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-4 text-gray-600 leading-relaxed">
                        Ada. Setiap kali seseorang mengklik link di profil Anda, kami mencatatnya. Anda bisa melihat grafik statistik kunjungan langsung dari Dashboard Anda.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            
            <div class="text-center md:text-left">
                <div class="font-bold text-xl text-gray-900 mb-1">TautanApp</div>
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Hak Cipta Dilindungi.</p>
            </div>

            <div class="flex gap-6 text-sm text-gray-500 font-medium">
                <a href="#" class="hover:text-indigo-600 transition">Tentang</a>
                <a href="#" class="hover:text-indigo-600 transition">Privasi</a>
                <a href="#" class="hover:text-indigo-600 transition">Syarat Ketentuan</a>
            </div>

        </div>
    </footer>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>