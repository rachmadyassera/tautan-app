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
}
