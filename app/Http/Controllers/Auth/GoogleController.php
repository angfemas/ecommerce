<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    // Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google.');
        }

        // Cek apakah user sudah ada berdasarkan Google ID
        $user = User::where('google_id', $googleUser->getId())->first();

        // Jika user belum ada, cek berdasarkan email
        if (!$user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            // Jika belum ada user, buat user baru
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(str()->random(16)), // Generate password random
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                // Update Google ID jika sebelumnya daftar dengan email
                $user->update(['google_id' => $googleUser->getId()]);
            }
        }

        // Login user
        Auth::login($user);

        return redirect('/dashboard'); // Redirect setelah login
    }
}