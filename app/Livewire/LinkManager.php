<?php

namespace App\Livewire;

use App\Models\Link;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LinkManager extends Component
{
    // Variabel untuk Form Input
    public $title = '';
    public $url = '';

    // Listener agar komponen refresh otomatis jika ada event tertentu
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        // Ambil link terbaru milik user, urutkan berdasarkan posisi
        $links = Auth::user()->page->links()->orderBy('position')->get();

        return view('livewire.link-manager', compact('links'));
    }

    // 1. Fitur Tambah Link
    public function saveLink()
    {
        $this->validate([
            'title' => 'required|max:255',
            'url' => 'required|url',
        ]);

        Link::create([
            'page_id' => Auth::user()->page->id,
            'title' => $this->title,
            'url' => $this->url,
            'position' => Link::where('page_id', Auth::user()->page->id)->max('position') + 1, // Taruh di urutan paling bawah
        ]);

        // Reset form input
        $this->reset(['title', 'url']);

        // Kirim notifikasi sukses (opsional, bisa pakai session flash)
        session()->flash('success', 'Link berhasil ditambahkan!');
    }

    // 2. Fitur Hapus Link
    public function deleteLink($id)
    {
        $link = Link::findOrFail($id);

        // Security check
        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        $link->delete();
    }

    // 3. Fitur Reorder (Drag & Drop Logic)
    public function updateLinkOrder($list)
    {
        // $list adalah array urutan baru yang dikirim oleh JavaScript
        foreach ($list as $item) {
            Link::where('id', $item['value'])->update(['position' => $item['order']]);
        }
    }
}
