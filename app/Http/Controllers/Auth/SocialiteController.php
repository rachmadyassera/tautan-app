<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SocialAccount;
use App\Models\Page; // Pastikan Model Page sudah ada (jika belum, buat dummy dulu atau hapus bagian ini)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    // 1. Mengarahkan user ke Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Menerima balasan dari Google
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $socialUser = Socialite::driver('google')->user();

            // Cari apakah akun Google ini sudah ada di database kita?
            $account = SocialAccount::where('provider_id', $socialUser->getId())
                ->where('provider_name', 'google')
                ->first();

            // SKENARIO A: Akun Google sudah terdaftar -> Langsung Login
            if ($account) {
                Auth::login($account->user);
                return redirect('/dashboard');
            }

            // SKENARIO B: Akun Google belum ada, tapi Emailnya mungkin sudah terdaftar manual
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Hubungkan akun Google ke user yang sudah ada
                $user->socialAccounts()->create([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => 'google'
                ]);

                Auth::login($user);
                return redirect('/dashboard');
            }

            // SKENARIO C: User Benar-benar Baru (Daftar & Buat Page Otomatis)
            // Kita gunakan DB Transaction biar kalau gagal, semua batal (aman)
            DB::transaction(function () use ($socialUser) {
                // 1. Buat User Baru
                $newUser = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => null, // Password kosong karena pakai Google
                    'avatar' => $socialUser->getAvatar(),
                ]);

                // 2. Simpan Data Akun Google
                SocialAccount::create([
                    'user_id' => $newUser->id,
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => 'google'
                ]);

                // 3. (PENTING) Buat Halaman Bio Default Otomatis!
                // Generate slug unik dari nama, misal: "Rachmad" jadi "rachmad-8231"
                $slug = Str::slug($socialUser->getName()) . '-' . rand(1000, 9999);

                // Pastikan Anda sudah membuat Model Page sebelumnya.
                // Jika belum, komentar dulu bagian Page::create ini.

                Page::create([
                    'user_id' => $newUser->id,
                    'title' => 'Link Bio ' . $newUser->name,
                    'slug' => $slug,
                    'theme' => 'light', // Default theme
                    'avatar_path' => $socialUser->getAvatar(),
                ]);


                // Login User Baru
                Auth::login($newUser);
            });

            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Jika error, kembalikan ke login dengan pesan
            return redirect()->route('login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}
