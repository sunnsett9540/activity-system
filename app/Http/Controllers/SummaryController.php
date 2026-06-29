<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function index()
    {
        // 1. ตรวจสอบสิทธิ์
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'แอดมินไม่สามารถเข้าถึงหน้าสรุปกิจกรรมได้');
        }

        $user = Auth::user();

        // 2. ดึงกิจกรรม + ตรวจสอบการเข้าร่วม
        $events = Event::leftJoin('attendance_logs', function ($join) use ($user) {

            $join->on('events.event_code', '=', 'attendance_logs.command_code')
                 ->where('attendance_logs.student_id', $user->student_id);

        })
        ->select(
            'events.event_code',
            'events.event_name',
            'events.date',
            'events.end_date',
            'events.start_time',
            'events.location',
            DB::raw('IF(attendance_logs.id IS NOT NULL, "เข้าร่วม", "") as status')
        )
        ->orderByRaw('CAST(events.event_code AS UNSIGNED) ASC')
        ->get();

        return view('summary', compact('events'));
    }
}