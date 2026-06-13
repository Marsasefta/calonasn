<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminWhatsappBlastController extends Controller
{
    private const DEFAULT_TEMPLATE = "🔥 *Kak [Nama], Admin Tambahkan Voucher Rp9.000 untuk Pesanan Kakak!*\n\nHalo Kak,\n\nPesanan Kakak di CalonASN.id masih tersimpan dan belum diselesaikan.\n\nAgar lebih hemat, Admin memberikan voucher diskon khusus:\n\n🎁 Kode Promo: *DISKON9000*\n\nPotongan langsung Rp9.000 untuk paket yang Kakak pilih.\n\n⏰ Berlaku sampai *23.59 WIB besok malam.*\n\nSetelah itu voucher akan otomatis berakhir dan tidak dapat digunakan kembali.\n\n👉 Lanjutkan pembayaran:\nwww.calonasn.id/pilih-paket\n\nJangan sampai voucher Rp9.000 ini hangus ya, Kak. 😊";
    
    public function index()
    {
        $users = User::query()
            ->where('role', 'user')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.whatsapp_blast', [
            'users' => $users,
            'defaultTemplate' => self::DEFAULT_TEMPLATE,
        ]);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:10'],
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'delay' => ['nullable', 'integer', 'min:1', 'max:60'],
        ], [
            'user_ids.required' => 'Pilih minimal satu peserta untuk dikirimi WhatsApp.',
            'message.required' => 'Template pesan WhatsApp wajib diisi.',
        ]);

        $users = User::query()
            ->whereIn('id', $validated['user_ids'])
            ->whereNotNull('phone')
            ->get();

        $targets = $users
            ->map(function (User $user) {
                $phone = $this->normalizePhone($user->phone);

                if ($phone === null) {
                    return null;
                }

                return $phone . '|' . $this->sanitizeTargetValue($user->name) . '|' . $this->sanitizeTargetValue($user->email);
            })
            ->filter()
            ->values();

        if ($targets->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Tidak ada peserta terpilih yang memiliki nomor WhatsApp valid.');
        }

        $message = str_replace('[Nama]', '{name}', $validated['message']);
        $token = config('services.fonnte.token', '112233445566778899');

        $response = Http::asForm()
            ->withHeaders(['Authorization' => $token])
            ->timeout(30)
            ->post('https://api.fonnte.com/send', [
                'target' => $targets->implode(','),
                'message' => $message,
                'delay' => (string) ($validated['delay'] ?? 2),
                'countryCode' => '62',
            ]);

        if ($response->failed()) {
            return back()
                ->withInput()
                ->with('error', 'Blast WhatsApp gagal dikirim. Response Fonnte: ' . $response->body());
        }

        $responseData = $response->json();

        if (is_array($responseData) && array_key_exists('status', $responseData) && $responseData['status'] === false) {
            return back()
                ->withInput()
                ->with('error', 'Blast WhatsApp ditolak oleh Fonnte: ' . $response->body());
        }

        return back()->with('success', 'Blast WhatsApp berhasil diproses untuk ' . $targets->count() . ' peserta.');
    }

    private function normalizePhone(?string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '62')) {
            $digits = '0' . substr($digits, 2);
        }

        return strlen($digits) >= 9 ? $digits : null;
    }

    private function sanitizeTargetValue(?string $value): string
    {
        return str_replace(['|', ','], ' ', trim((string) $value));
    }
}
