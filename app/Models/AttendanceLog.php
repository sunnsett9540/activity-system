<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $table = 'attendance_logs';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'command_code',
        'log_date',
        'log_time'
    ];

    /**
     * ความสัมพันธ์กับ users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'student_id');
    }

    /**
     * ความสัมพันธ์กับ events
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'command_code', 'event_code');
    }
}