<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // จำนวนกิจกรรมที่ผู้ใช้เข้าร่วม
        $totalEvents = DB::table('attendance_logs')
            ->where('student_id', $user->student_id)
            ->count();

        // กิจกรรมล่าสุด 
      $events = Event::leftJoin('attendance_logs', 'events.event_code', '=', 'attendance_logs.command_code')
    ->select(
        'events.*',
        DB::raw('COUNT(attendance_logs.id) as participants')
    )
    ->groupBy(
        'events.id',
        'events.event_code',
        'events.event_name',
        'events.date',
        'events.end_date',
        'events.is_scanning',
        'events.start_time',
        'events.end_time',
        'events.location',
        'events.description',
        'events.created_at',
        'events.updated_at'
    )
    ->orderByRaw('CAST(events.event_code AS UNSIGNED) ASC')
    ->limit(5)
    ->get();

        return view('dashboard', compact('user', 'events', 'totalEvents'));
    }
}