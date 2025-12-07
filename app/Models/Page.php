<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // Izinkan kolom ini diisi massal
    protected $fillable = ['user_id', 'title', 'slug', 'bio_text', 'theme', 'avatar_path'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Links
    public function links()
    {
        // Ambil link, urutkan berdasarkan posisi (0, 1, 2...)
        return $this->hasMany(Link::class)->orderBy('position', 'asc');
    }

    // ACCESSOR BARU: Panggil dengan $page->avatar_url
    public function getAvatarUrlAttribute()
    {
        // 1. Jika ada foto tersimpan (Google atau Upload)
        if ($this->avatar_path) {
            // Cek apakah link eksternal (http) atau lokal (storage)
            if (str_starts_with($this->avatar_path, 'http')) {
                return $this->avatar_path;
            }
            return asset('storage/' . $this->avatar_path);
        }

        // 2. Jika TIDAK ADA foto (Null), pakai UI Avatars
        // Kita ambil inisial dari Title halaman
        $name = urlencode($this->title);
        return "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&size=200";
    }
}
