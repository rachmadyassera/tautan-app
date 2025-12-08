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

    public $soc_instagram, $soc_tiktok, $soc_twitter, $soc_facebook, $soc_whatsapp, $soc_youtube;

    public function mount()
    {
        $page = Auth::user()->page;

        $this->title = $page->title;
        $this->bio_text = $page->bio_text;
        $this->theme = $page->theme ?? 'default';
        $this->existingAvatar = $page->avatar_path;
        $this->slug = $page->slug;

        // LOAD DATA SOSMED
        $this->soc_instagram = $page->soc_instagram;
        $this->soc_tiktok    = $page->soc_tiktok;
        $this->soc_twitter   = $page->soc_twitter;
        $this->soc_facebook  = $page->soc_facebook;
        $this->soc_whatsapp  = $page->soc_whatsapp;
        $this->soc_youtube   = $page->soc_youtube;
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
            'soc_instagram' => 'nullable|url',
            'soc_tiktok'    => 'nullable|url',
            'soc_twitter'   => 'nullable|url',
            'soc_facebook'  => 'nullable|url',
            'soc_whatsapp'  => 'nullable|url', // Bisa diisi https://wa.me/628...
            'soc_youtube'   => 'nullable|url',
        ]);

        $page = Auth::user()->page;
        $data = [
            'title' => $this->title,
            'bio_text' => $this->bio_text,
            'theme' => $this->theme,
            'slug' => $this->slug,
            'soc_instagram' => $this->soc_instagram,
            'soc_tiktok'    => $this->soc_tiktok,
            'soc_twitter'   => $this->soc_twitter,
            'soc_facebook'  => $this->soc_facebook,
            'soc_whatsapp'  => $this->soc_whatsapp,
            'soc_youtube'   => $this->soc_youtube,
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
