<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function update(Request $request)
    {
        $page = Auth::user()->page;

        // 1. Validasi Input
        $request->validate([
            // Validasi Slug: Wajib diisi, format huruf/angka/- (alpha_dash), dan harus unik di tabel pages
            // PENTING: Kita tambahkan pengecualian (. $page->id) agar slug milik sendiri tidak dianggap duplikat
            'slug' => 'required|alpha_dash|max:50|unique:pages,slug,' . $page->id,

            'title' => 'required|string|max:255',
            'bio_text' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'theme' => 'required|string', // <--- TAMBAHKAN VALIDASI INI
        ]);

        // 2. Update Data
        $page->slug = $request->slug; // Simpan slug baru
        $page->title = $request->title;
        $page->bio_text = $request->bio_text;
        $page->theme = $request->theme; // <--- SIMPAN TEMA

        // 3. Cek Upload Foto (Logika sama seperti sebelumnya)
        if ($request->hasFile('avatar')) {
            if ($page->avatar_path && !str_starts_with($page->avatar_path, 'http')) {
                Storage::disk('public')->delete($page->avatar_path);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $page->avatar_path = $path;
        }

        $page->save();

        return redirect()->back()->with('success', 'Profil dan URL berhasil diperbarui!');
    }
}
