<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    /**
     * Menampilkan halaman daftar kode promo
     */
    public function index()
    {
        // Mengambil data promo terbaru
        $promoCodes = PromoCode::latest()->get();
        
        // Diarahkan langsung ke views/admin/promo_code.blade.php
        return view('admin.promo_code', compact('promoCodes'));
    }

    /**
     * Menyimpan kode promo baru dari modal bootstrap
     */
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'code' => 'required|unique:promo_codes,code|max:50',
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif',
        ], [
            'code.unique' => 'Kode promo ini sudah pernah dibuat!',
            'code.required' => 'Kode promo wajib diisi.',
            'discount_amount.required' => 'Jumlah potongan harga wajib diisi.',
        ]);

        // Menyimpan data ke database
        PromoCode::create([
            'code' => strtoupper(str_replace(' ', '', $request->code)), // Menghapus spasi & otomatis kapital
            'discount_amount' => $request->discount_amount,
            'status' => $request->status,
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Kode promo baru berhasil ditambahkan!');
    }

    /**
     * Memperbarui data kode promo via modal edit
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:50|unique:promo_codes,code,' . $id,
            'discount_amount' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif',
        ], [
            'code.unique' => 'Kode promo ini sudah digunakan!',
        ]);

        $promo = PromoCode::findOrFail($id);
        $promo->update([
            'code' => strtoupper(str_replace(' ', '', $request->code)),
            'discount_amount' => $request->discount_amount,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Kode promo berhasil diperbarui!');
    }

    /**
     * Menghapus data kode promo via modal konfirmasi
     */
    public function destroy($id)
    {
        $promo = PromoCode::findOrFail($id);
        $promo->delete();

        return redirect()->back()->with('success', 'Kode promo berhasil dihapus!');
    }
}