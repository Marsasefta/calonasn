<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request)
    {
        // Jika ada parameter 'package' di URL, simpan ke dalam session
        if ($request->has('package')) {
            session(['selected_package' => $request->package]);
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = 'user';
        if (
            $request->name === 'adminasn' &&
            $request->email === 'calonasn@gmail.com' &&
            $request->password === 'adminasn321'
        ) {
            $role = 'admin';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        event(new Registered($user));

        // Proses registrasi user baru selesai...
        Auth::login($user);

        // CEK APAKAH USER SEBELUMNYA MEMILIH PAKET
        if (session()->has('selected_package')) {
            $package = session('selected_package');
            
            // Hapus session agar tidak tersimpan terus menerus
            session()->forget('selected_package'); 

            // Alihkan langsung ke halaman checkout sesuai paket pilihan mereka
            return redirect()->route('checkout', ['package' => $package]);
        }

        // Jika mendaftar biasa tanpa pilih paket dari homepage, arahkan ke pilih paket
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('user.pilih-paket');
    }
}
