<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreeTryoutCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class FreeTryoutController extends Controller
{
    public function index()
    {
        $codes = FreeTryoutCode::with('user')->latest()->paginate(20);
        return view('admin.free-tryout.index', compact('codes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
        ]);

        $user = User::create([
            'name' => 'Peserta Tryout Gratis',
            'email' => 'gratis_' . Str::random(10) . '@calonasn.id',
            'password' => Hash::make(Str::random(16)),
            'role' => 'user',
        ]);

        $code = 'TO-' . strtoupper(Str::random(8));

        FreeTryoutCode::create([
            'code' => $code,
            'user_id' => $user->id,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
        ]);

        return back()->with('success', 'Kode berhasil digenerate: ' . $code);
    }
}
