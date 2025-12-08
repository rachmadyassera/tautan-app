<?php

namespace App\Models;

use Illuminate\Support\Str; // <--- Import ini di paling atas
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['page_id', 'title', 'url', 'thumbnail', 'is_active', 'position', 'short_code', 'is_header',];

    // Logic "Boot": Jalan otomatis saat data dibuat
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
            // Jika short_code belum ada, buatkan random 6 karakter
            if (empty($link->short_code)) {
                $link->short_code = Str::random(6);
            }
        });
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
