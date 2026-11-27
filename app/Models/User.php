<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_premium',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function examSessions()
    {
        return $this->hasMany(ExamSession::class);
    }

    public function getPackageStatusAttribute(): string
    {
        if (isset($this->attributes['package_status'])) {
            return $this->attributes['package_status'];
        }

        $successTx = $this->relationLoaded('transactions')
            ? $this->transactions->filter(fn($t) => strtolower($t->status) === 'success')
            : $this->transactions()->whereRaw('LOWER(status) = ?', ['success'])->get();

        $tryoutIds = $successTx->pluck('tryout_id')->toArray();
        $hasPaket1 = in_array(1, $tryoutIds);
        $hasPaket2 = in_array(2, $tryoutIds);
        $hasPaket3 = in_array(3, $tryoutIds);

        if ($hasPaket2 || ($hasPaket1 && $hasPaket3)) {
            return 'lengkap';
        } elseif ($hasPaket1) {
            return 'tryout';
        } elseif ($this->is_premium) {
            return 'manual';
        }

        return 'free';
    }

    public function getPackageLabelAttribute(): string
    {
        return match ($this->package_status) {
            'lengkap' => 'Paket Lengkap',
            'tryout'  => 'Tryout Saja',
            'manual'  => 'PRO Khusus',
            default   => 'Free User',
        };
    }

    public function getPackageSublabelAttribute(): string
    {
        return match ($this->package_status) {
            'lengkap' => 'Tryout + Materi',
            'tryout'  => 'Belum Materi',
            'manual'  => 'Akses Manual',
            default   => 'Belum Beli',
        };
    }

    /**
     * Ambil data promo pendaftar baru (berakhir 2 jam setelah waktu daftar).
     */
    public function newMemberPromo(): ?array
    {
        if ($this->isAdmin() || $this->is_premium || !$this->created_at) {
            return null;
        }

        $hasPaidPackage = $this->relationLoaded('transactions')
            ? $this->transactions->contains(fn ($t) => strtolower((string) $t->status) === 'success' && in_array((int) $t->tryout_id, [1, 2, 3], true))
            : $this->transactions()
                ->whereRaw('LOWER(status) = ?', ['success'])
                ->whereIn('tryout_id', [1, 2, 3])
                ->exists();

        if ($hasPaidPackage) {
            return null;
        }

        $tz = config('app.timezone', 'Asia/Jakarta');
        $registeredAt = $this->created_at->copy()->timezone($tz);
        $expiresAt = $registeredAt->copy()->addHours(2);

        $now = now($tz);
        $remainingSeconds = (int) $now->diffInSeconds($expiresAt, false);

        if ($remainingSeconds <= 0) {
            return null;
        }

        $promo = PromoCode::where('code', 'ASN2026')
            ->where('status', 'aktif')
            ->first();

        if (!$promo) {
            return null;
        }

        $dayPrefix = $expiresAt->isSameDay($now) ? 'Hari Ini' : 'Besok';
        $deadlineLabel = $dayPrefix . ' Pukul ' . $expiresAt->format('H:i') . ' WIB';

        return [
            'promo_id'          => $promo->id,
            'code'              => $promo->code,
            'discount_amount'   => (int) $promo->discount_amount,
            'expires_at'        => $expiresAt,
            'deadline_label'    => $deadlineLabel,
            'remaining_seconds' => $remainingSeconds,
        ];
    }

    /**
     * Normalisasi nomor WhatsApp ke awalan '62' (wa.me) atau '0' (lokal/Fonnte).
     */
    public static function normalizeWhatsappNumber(?string $phone, string $prefix = '62'): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '' || strlen($digits) < 9) {
            return null;
        }

        if (str_starts_with($digits, '62')) {
            $local = substr($digits, 2);
        } elseif (str_starts_with($digits, '0')) {
            $local = substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $local = $digits;
        } else {
            return $digits;
        }

        return strlen($local) >= 8 ? $prefix . $local : null;
    }

    /**
     * Samarkan sebagian nama user untuk tampilan publik (mis. "Andri S.").
     */
    public function maskedName(): string
    {
        $rawName = trim((string) ($this->name ?? ''));
        if ($rawName === '') {
            return 'Peserta CalonASN';
        }

        $parts = preg_split('/\s+/', $rawName) ?: [];
        if (count($parts) >= 2) {
            $first = mb_convert_case($parts[0], MB_CASE_TITLE, 'UTF-8');
            $initials = [];
            foreach (array_slice($parts, 1) as $part) {
                $char = mb_strtoupper(mb_substr($part, 0, 1, 'UTF-8'), 'UTF-8');
                if ($char !== '') {
                    $initials[] = $char . '.';
                }
            }

            return trim($first . ' ' . implode(' ', $initials));
        }

        $single = mb_convert_case($parts[0], MB_CASE_TITLE, 'UTF-8');
        $len = mb_strlen($single, 'UTF-8');
        if ($len <= 3) {
            return mb_substr($single, 0, 1, 'UTF-8') . '***';
        }

        return mb_substr($single, 0, 3, 'UTF-8') . '***';
    }
}
