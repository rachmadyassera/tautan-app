<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function visit($code) // Parameter ganti jadi $code
    {
        // Cari berdasarkan short_code, bukan ID
        $link = Link::where('short_code', $code)->firstOrFail();

        $link->increment('click_count');

        if ($link->is_header || empty($link->url)) {
            return redirect()->back();
        }

        return redirect()->away($link->url);
    }
}
