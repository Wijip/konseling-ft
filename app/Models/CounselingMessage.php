<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'counseling_session_id',
        'sender_type',
        'message',
    ];

    public function session()
    {
        return $this->belongsTo(CounselingSession::class, 'counseling_session_id');
    }
}
