<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari apakah user dengan email ini sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika sudah ada, langsung loginkan
                Auth::login($user);
            } else {
                // Jika belum ada, buat user baru (Register otomatis)
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(str()->random(16)),// password acak aman
                ]);

                Auth::login($newUser);
            }

            // Cek apakah ada session paket (dari URL register?package=...)
            if (session()->has('selected_package')) {
                $package = session('selected_package');
                session()->forget('selected_package');
                return redirect()->route('checkout', ['package' => $package])->with('login_success', 'Selamat Datang! Anda berhasil masuk menggunakan Google.');
            }

            $loggedInUser = Auth::user();
            if ($loggedInUser && $loggedInUser->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('login_success', 'Selamat Datang Admin!');
            }

            return redirect()->route('user.pilih-paket')->with('login_success', 'Selamat Datang! Anda berhasil masuk menggunakan Google.');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google.');
        }
    }
}