<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CounselingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'name',
        'email',
        'employee_id',
        'faculty_origin',
        'division',
        'identity_type',
        'phone_number',
        'topic',
        'duration',
        'jabatan',
        'issue_description',
        'additional_notes',
        'status',
        'assigned_konselor_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->tracking_code = 'CS-' . strtoupper(Str::random(8));
        });
    }

    public function messages()
    {
        return $this->hasMany(CounselingMessage::class);
    }

    public function konselor()
    {
        return $this->belongsTo(User::class, 'assigned_konselor_id');
    }
}
