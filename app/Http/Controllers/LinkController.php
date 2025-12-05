<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    // 1. Simpan Link Baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'url' => 'required|url' // Wajib format URL (http://...)
        ]);

        // Ambil Page milik user yang sedang login
        $page = Auth::user()->page;

        // Simpan ke database
        Link::create([
            'page_id' => $page->id,
            'title' => $request->title,
            'url' => $request->url,
            'is_active' => true,
            'position' => 0 // Nanti kita atur urutannya
        ]);

        // Kembali ke dashboard dengan pesan sukses
        return redirect()->back()->with('success', 'Link berhasil ditambahkan!');
    }

    // 2. Hapus Link
    public function destroy(Link $link)
    {
        // Cek kepemilikan (Security Check)
        // Jangan sampai user A menghapus link milik user B
        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        $link->delete();

        return redirect()->back()->with('success', 'Link dihapus.');
    }
}
