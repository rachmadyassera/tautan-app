<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - TautanKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 h-screen flex flex-col justify-center items-center text-center px-6">

    <div class="text-9xl mb-4 font-black text-indigo-100 select-none">
        404
    </div>

    <div class="relative -mt-16">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
            Ups! Profil Tidak Ditemukan.
        </h1>
        <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto">
            Link yang Anda tuju mungkin salah ketik, sudah dihapus, atau pemiliknya sedang bersembunyi di goa.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-full hover:bg-gray-300 transition">
                &larr; Kembali ke Depan
            </a>
            
            <a href="{{ route('register') }}" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition shadow-lg hover:shadow-xl hover:-translate-y-1 transform">
                Buat Tautan Link Gratis
            </a>
        </div>
    </div>

    <div class="absolute bottom-6 text-sm text-gray-400">
        &copy; {{ date('Y') }} Tautan App.
    </div>

</body>
</html>