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