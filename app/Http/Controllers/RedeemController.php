<?php

namespace App\Http\Controllers;

use App\Models\FreeTryoutCode;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedeemController extends Controller
{
    public function index()
    {
        return view('redeem');
    }

    public function process(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = FreeTryoutCode::where('code', $request->code)->first();

        if (!$code) {
            return back()->with('error', 'Kode tidak valid.');
        }

        $today = now()->startOfDay();
        if ($today < $code->valid_from || $today > $code->valid_until) {
            return back()->with('error', 'Kode tidak dapat digunakan pada tanggal ini.');
        }

        // Login the user associated with the code
        Auth::loginUsingId($code->user_id);

        // Give access to Tryout ID 1 if they don't have it
        $hasTryout = Transaction::where('user_id', $code->user_id)
            ->where('tryout_id', 1)
            ->where('status', 'success')
            ->exists();

        if (!$hasTryout) {
            Transaction::create([
                'user_id' => $code->user_id,
                'tryout_id' => 1,
                'order_id' => 'TRX-FREE-' . time() . '-' . $code->user_id,
                'amount' => 0,
                'total_amount' => 0,
                'status' => 'success',
                'payment_method' => 'free',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Berhasil masuk dengan kode tryout gratis!');
    }
}
