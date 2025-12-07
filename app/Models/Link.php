<?php

namespace App\Models;

use Illuminate\Support\Str; // <--- Import ini di paling atas
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['page_id', 'title', 'url', 'thumbnail', 'is_active', 'position', 'short_code'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Method "booted" ini jalan otomatis saat Model diakses
    protected static function booted()
    {
        static::creating(function ($link) {
            // Sebelum disimpan, buatkan kode acak 6 karakter
            // Contoh: aB3x9Z
            $link->short_code = Str::random(6);
        });
    }
}
