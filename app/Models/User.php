<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Field;
use App\Models\AttendanceLog;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'student_id',
        'field_id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ความสัมพันธ์กับตาราง fields
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    // ความสัมพันธ์กับตาราง attendancelogs
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }
}