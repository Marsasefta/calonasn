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
}
