<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'nim_nip',
        'rumpun',
        'avatar',
        'password',
        'role',
    ];

    /**
     * Cek apakah user adalah Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah Konselor atau Admin
     */
    public function isKonselor(): bool
    {
        return $this->role === 'konselor' || $this->role === 'admin';
    }

    /**
     * Cari user berdasarkan nomor WhatsApp / HP dengan fleksibilitas format (08, 62, +62)
     */
    public static function findByPhone(?string $rawPhone): ?self
    {
        if (empty($rawPhone)) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $rawPhone);
        if (empty($clean)) {
            return null;
        }

        // Variasi format nomor
        $variations = [$rawPhone, $clean];
        if (str_starts_with($clean, '62')) {
            $variations[] = '0' . substr($clean, 2);
            $variations[] = '+' . $clean;
            $variations[] = substr($clean, 2);
        } elseif (str_starts_with($clean, '0')) {
            $variations[] = '62' . substr($clean, 1);
            $variations[] = '+62' . substr($clean, 1);
            $variations[] = substr($clean, 1);
        }

        return static::where(function ($query) use ($variations) {
            foreach (array_unique($variations) as $var) {
                $query->orWhere('phone_number', $var);
            }
        })->first();
    }

    /**
     * Relasi ke Sesi Konseling Chat berdasarkan email user
     */
    public function counselingSessions(): HasMany
    {
        return $this->hasMany(CounselingSession::class, 'email', 'email');
    }

    /**
     * Relasi ke Booking Pertemuan berdasarkan email user
     */
    public function meetingBookings(): HasMany
    {
        return $this->hasMany(MeetingBooking::class, 'email', 'email');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }
}