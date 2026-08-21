<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon $schedule_date
 */
class MeetingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',        // DITAMBAHKAN: Untuk relasi ke akun Konselor/User
        'konselor_name',
        'rumpun',         // DITAMBAHKAN: Untuk menyimpan data Rumpun (Informatika, Sipil, dll)
        'schedule_date',
        'start_time',
        'end_time',
        'max_slots',
        'booked_slots',
        'is_available',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'is_available'  => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(MeetingBooking::class);
    }

    public function konselor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}