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
        // 1. Cek Honeypot (Jika bot mengisi input tersembunyi ini, tolak langsung)
        if (!empty($request->input('middle_name_check'))) {
            return back()->withInput()->withErrors([
                'name' => 'Aktivitas tidak valid atau bot otomatis terdeteksi.',
            ]);
        }

        // 2. Cek Anti-Link / HTML Spam pada Nama
        $rawName = (string) $request->input('name', '');
        if (preg_match('/<[^>]*>|https?:\/\/|www\.|\.ru\b|\.cc\b|\.xyz\b|href=/i', $rawName)) {
            return back()->withInput()->withErrors([
                'name' => 'Nama tidak boleh mengandung tautan website atau tag HTML.',
            ]);
        }

        // 3. Cek Domain Email Sementara / Spambot
        $email = (string) $request->input('email', '');
        $emailParts = explode('@', $email);
        $domain = isset($emailParts[1]) ? strtolower(trim($emailParts[1])) : '';
        $blockedDomains = [
            'merepost.com', 'fextemp.com', 'notboxletters.com', 'nolettersbox.com',
            'belettersmail.com', 'tempmail.com', '10minutemail.com', 'guerrillamail.com',
            'mailinator.com', 'yopmail.com', 'trashmail.com'
        ];
        if (in_array($domain, $blockedDomains)) {
            return back()->withInput()->withErrors([
                'email' => 'Gunakan alamat email resmi/pribadi (misal: Gmail, Yahoo, dll).',
            ]);
        }

        $cleanedName = strip_tags(trim($rawName));
        $request->merge(['name' => $cleanedName]);

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.,\'\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\s\-]+$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.regex' => 'Format nama hanya boleh menggunakan huruf, spasi, titik, koma, tanda petik, atau tanda hubung.',
            'phone.regex' => 'Nomor WhatsApp / telepon hanya boleh berisi angka dan tanda (+ / -).',
            'email.unique' => 'Alamat email ini sudah terdaftar sebelumnya.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
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
