<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class MeetingBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'meeting_type',
        'meeting_schedule_id',
        'name',
        'email',
        'phone_number',
        'employee_id',
        'division',
        'jabatan',
        'purpose',
        'additional_notes',
        'status',
        'admin_notes',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->tracking_code = 'MB-' . strtoupper(Str::random(8));
        });
    }

    public function schedule()
    {
        return $this->belongsTo(MeetingSchedule::class, 'meeting_schedule_id');
    }


    public static function autoCompleteStatuses()
    {


        $approvedBookings = self::where('status', 'approved')
            ->with('schedule')
            ->get();

        foreach ($approvedBookings as $booking) {
            /** @var MeetingBooking $booking */
            if ($booking->schedule) {
                $endDateTime = Carbon::parse(
                    $booking->schedule->schedule_date->format('Y-m-d') . ' ' . $booking->schedule->end_time
                );

                if (Carbon::now()->greaterThan($endDateTime)) {
                    $booking->update(['status' => 'completed']);
                }
            }
        }
    }
}

