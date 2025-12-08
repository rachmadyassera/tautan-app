<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageSettings extends Component
{
    use WithFileUploads;

    public $title;
    public $bio_text;
    public $avatar; // Untuk upload baru
    public $existingAvatar; // Untuk preview avatar lama
    public $theme;
    public $slug;

    public function mount()
    {
        $page = Auth::user()->page;

        $this->title = $page->title;
        $this->bio_text = $page->bio_text;
        $this->theme = $page->theme ?? 'default';
        $this->existingAvatar = $page->avatar_path;
        $this->slug = $page->slug;
    }

    public function saveSettings()
    {

        $pageId = Auth::user()->page->id;
        $this->validate([
            'title' => 'required|max:50',
            'bio_text' => 'nullable|max:160',
            'avatar' => 'nullable|image|max:2048', // Max 2MB
            'theme' => 'required',
            // VALIDASI SLUG (PENTING!)
            // required: wajib isi
            // alpha_dash: cuma boleh huruf, angka, strip (-), dan underscore (_)
            // unique:pages,slug,$pageId: Cek unik di tabel pages, TAPI abaikan punya sendiri (biar gak error kalau gak diganti)
            'slug' => 'required|alpha_dash|max:50|unique:pages,slug,' . $pageId,
        ]);

        $page = Auth::user()->page;
        $data = [
            'title' => $this->title,
            'bio_text' => $this->bio_text,
            'theme' => $this->theme,
            'slug' => $this->slug,
        ];

        // Logic Upload Avatar
        if ($this->avatar) {
            // Hapus avatar lama jika bukan default/kosong
            if ($page->avatar_path && Storage::disk('public')->exists($page->avatar_path)) {
                Storage::disk('public')->delete($page->avatar_path);
            }

            // Simpan yang baru
            $data['avatar_path'] = $this->avatar->store('avatars', 'public');
        }

        $page->update($data);

        // Reset input file agar preview kembali normal
        $this->avatar = null;
        $this->existingAvatar = $page->fresh()->avatar_path;

        session()->flash('settingsSuccess', 'Profil berhasil diperbarui!');

        // Emit event agar komponen lain (opsional) tahu ada perubahan
        $this->dispatch('pageUpdated');
    }

    public function render()
    {
        return view('livewire.page-settings');
    }
}
