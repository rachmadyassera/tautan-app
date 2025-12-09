<?php

namespace App\Livewire;

use App\Models\Link;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class LinkManager extends Component
{
    use WithFileUploads;

    // Variabel Form
    public $title = '';
    public $url = '';
    public $photo;

    // BARU: Variabel untuk menentukan apakah ini header atau link biasa
    public $is_header = false;

    // Variabel Edit Mode
    public $linkIdBeingEdited = null;
    public $iteration = 1;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        $links = Auth::user()->page->links()->orderBy('position')->get();
        return view('livewire.link-manager', compact('links'));
    }

    public function saveLink()
    {
        // 1. Validasi Dinamis
        // Kalau Header dicentang, URL boleh kosong. Kalau tidak, URL wajib.
        $rules = [
            'title' => 'required|max:255',
            'url' => $this->is_header ? 'nullable' : 'required|url',
            'photo' => 'nullable|image|max:1024',
        ];

        $this->validate($rules);

        // Siapkan data dasar
        $data = [
            'title' => $this->title,
            'url' => $this->is_header ? null : $this->url, // Kosongkan URL jika header
            'is_header' => $this->is_header ? true : false, // Simpan status header
        ];

        // LOGIKA UPDATE
        if ($this->linkIdBeingEdited) {
            $link = Link::find($this->linkIdBeingEdited);

            if (!$link || $link->page->user_id !== Auth::id()) {
                abort(403);
            }

            // Hanya update gambar jika user upload baru
            if ($this->photo) {
                $data['thumbnail'] = $this->photo->store('thumbnails', 'public');
            }

            $link->update($data);
            session()->flash('linkSuccess', 'Link berhasil diperbarui!');
        }
        // LOGIKA CREATE BARU
        else {
            $data['page_id'] = Auth::user()->page->id;

            // Simpan gambar jika ada
            $data['thumbnail'] = $this->photo ? $this->photo->store('thumbnails', 'public') : null;

            // Taruh di urutan paling bawah
            $data['position'] = Link::where('page_id', Auth::user()->page->id)->max('position') + 1;

            Link::create($data);
            session()->flash('linkSuccess', 'Link berhasil ditambahkan!');
        }

        $this->cancelEdit();

        $this->dispatch('contentUpdated');
    }

    public function editLink($id)
    {
        $link = Link::findOrFail($id);

        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }

        $this->linkIdBeingEdited = $id;
        $this->title = $link->title;
        $this->url = $link->url;

        // BARU: Load status header dari database
        $this->is_header = (bool) $link->is_header;

        // Force refresh form input
        $this->iteration++;
    }

    public function cancelEdit()
    {
        // Reset semua variabel termasuk is_header
        $this->reset(['title', 'url', 'photo', 'linkIdBeingEdited', 'is_header']);
        $this->iteration++;
    }

    public function deleteLink($id)
    {
        $link = Link::findOrFail($id);
        if ($link->page->user_id !== Auth::id()) {
            abort(403);
        }
        $link->delete();
        $this->dispatch('contentUpdated');
        session()->flash('linkSuccess', 'Link dihapus.');
    }

    public function updateLinkOrder($list)
    {
        foreach ($list as $item) {
            Link::where('id', $item['value'])->update(['position' => $item['order']]);
        }
        $this->dispatch('contentUpdated');
    }
}
