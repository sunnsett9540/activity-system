<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttendanceLog;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'event_code',
        'event_name',
        'date',
        'end_date',
        'is_scanning',
        'status',
        'start_time',
        'end_time',
        'location',
        'description'
    ];

    protected $casts = [
        'is_scanning' => 'boolean',
        'status' => 'string',
    ];

    /**
     * Refresh the status based on current time.
     */
    public function refreshStatus()
    {
        $now = \Carbon\Carbon::now();
        $start = \Carbon\Carbon::parse($this->date . ' ' . $this->start_time);
        $end = \Carbon\Carbon::parse(($this->end_date ?? $this->date) . ' ' . $this->end_time);
        if ($this->status === 'pending' && $now->gte($start) && $now->lt($end)) {
            $this->status = 'scanning';
            $this->save();
        } elseif ($this->status === 'scanning' && $now->gte($end)) {
            $this->status = 'stopped';
            $this->save();
        }
    }

    /**
     * ความสัมพันธ์กับ attendance_logs
     * 1 Event มีผู้เข้าร่วมหลายคน
     */
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class, 'event_id');
    }

    /**
     * นับจำนวนผู้เข้าร่วมกิจกรรม
     */
    public function getParticipantsCountAttribute()
    {
        return $this->attendanceLogs()->count();
    }
}