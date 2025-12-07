<?php

namespace App\Livewire;

use App\Models\Link;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class LinkManager extends Component
{

    use WithFileUploads;

    // Variabel untuk Form Input
    public $title = '';
    public $url = '';
    public $photo;

    // TAMBAHAN: Variabel untuk mode edit
    public $linkIdBeingEdited = null;

    public $iteration = 1;

    // Listener agar komponen refresh otomatis jika ada event tertentu
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        // Ambil link terbaru milik user, urutkan berdasarkan posisi
        $links = Auth::user()->page->links()->orderBy('position')->get();

        return view('livewire.link-manager', compact('links'));
    }

    // 1. Fitur Tambah Link
    // 1. MODIFIKASI: Method Simpan (Bisa create baru atau update)
    public function saveLink()
    {
        // Validasi dasar
        $rules = [
            'title' => 'required|max:255',
            // Jika mode header nanti ada, URL opsional. Tapi sekarang wajib.
            'url' => 'required|url',
            'photo' => 'nullable|image|max:1024',
        ];

        $this->validate($rules);

        // A. LOGIKA UPDATE
        if ($this->linkIdBeingEdited) {
            $link = Link::find($this->linkIdBeingEdited);

            // Security check
            if (!$link || $link->page->user_id !== Auth::id()) {
                abort(403);
            }

            $data = [
                'title' => $this->title,
                'url' => $this->url,
            ];

            // Cek apakah upload gambar baru?
            if ($this->photo) {
                $data['thumbnail'] = $this->photo->store('thumbnails', 'public');
            }

            $link->update($data);
            session()->flash('linkSuccess', 'Link berhasil diperbarui!');
        }
        // B. LOGIKA CREATE BARU
        else {
            $thumbnailPath = null;
            if ($this->photo) {
                $thumbnailPath = $this->photo->store('thumbnails', 'public');
            }

            Link::create([
                'page_id' => Auth::user()->page->id,
                'title' => $this->title,
                'url' => $this->url,
                'thumbnail' => $thumbnailPath,
                'position' => Link::where('page_id', Auth::user()->page->id)->max('position') + 1,
            ]);
            session()->flash('linkSuccess', 'Link berhasil ditambahkan!');
        }

        $this->cancelEdit(); // Reset form
    }

    // 2. TAMBAHAN: Fungsi Edit (Dipanggil saat tombol pensil diklik)
    public function editLink($id)
    {
        $link = Link::findOrFail($id);

        // Security check
        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        $this->linkIdBeingEdited = $id;
        $this->title = $link->title;
        $this->url = $link->url;

        // TAMBAHAN PENTING:
        // Ini memaksa form (yang pakai wire:key) untuk dirender ulang
        // sehingga nilai title & url yang baru akan masuk ke input.
        $this->iteration++;
    }

    // 3. TAMBAHAN: Fungsi Batal Edit
    public function cancelEdit()
    {
        $this->reset(['title', 'url', 'photo', 'linkIdBeingEdited']);
        $this->iteration++;
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
        session()->flash('linkSuccess', 'Link dihapus.');
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
