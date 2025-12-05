<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function show($slug)
    {
        // 1. Cari halaman berdasarkan SLUG
        // Gunakan 'firstOrFail' agar kalau slug ngawur, otomatis error 404
        $page = Page::where('slug', $slug)->firstOrFail();

        // 2. Ambil link yang aktif saja, urutkan sesuai posisi
        $links = $page->links()->where('is_active', true)->orderBy('position')->get();

        // 3. Rekam kunjungan (Sederhana dulu, tanpa tabel visits)
        // Nanti di Fase 2 kita update tabel visits di sini.

        // 4. Tampilkan view khusus publik
        return view('public-page', compact('page', 'links'));
    }
}
