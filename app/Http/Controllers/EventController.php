<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

   public function index()
{
    if (Auth::user()->role !== 'admin') {
        return redirect()->route('dashboard');
    }

    // เรียงรหัสกิจกรรม 0001 -> 0002 -> 0003 ...
    $events = Event::orderByRaw('CAST(event_code AS UNSIGNED) ASC')->get();

    return view('events.index', compact('events'));
}

    public function getParticipants($event_code)
    {

        $data = DB::table('attendance_logs')

        ->leftJoin('users','attendance_logs.student_id','=','users.student_id')

        ->where('attendance_logs.command_code',$event_code)

        ->select(
            'attendance_logs.command_code',
            DB::raw('MAX(attendance_logs.log_date) as log_date'),
            DB::raw('MAX(attendance_logs.log_time) as log_time'),
            'attendance_logs.student_id',
            'users.name as name'
        )

        ->groupBy(
            'attendance_logs.command_code',
            'attendance_logs.student_id',
            'users.name'
        )

        ->orderBy('log_time','desc')

        ->get();

        return response()->json($data);

    }


    public function create()
    {
        return view('events.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required',
            'date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required'
        ]);

        // หา event_code ล่าสุด
       $lastEvent = \App\Models\Event::orderByRaw('CAST(event_code AS UNSIGNED) DESC')->first();
        if($lastEvent){
            $newCode = intval($lastEvent->event_code) + 1;
        }else{
            $newCode = 1;
        }

        // แปลงเป็น 0001
        $event_code = str_pad($newCode,4,'0',STR_PAD_LEFT);

        $endDate = $request->input('end_date') ?: $request->date;

        \App\Models\Event::create([
            'event_code' => $event_code,
            'event_name' => $request->event_name,
            'date' => $request->date,
            'end_date' => $endDate,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location
        ]);

        return redirect()->route('events.index')->with('success','เพิ่มกิจกรรมสำเร็จ');
    }


    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }


    public function update(Request $request, Event $event)
    {
        // 1. ตัด 'event_code' ออกจากการตรวจสอบ
        $request->validate([
            'event_name' => 'required',
            'date'       => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:date',
            'start_time' => 'required',
            'end_time'   => 'required',
            'location'   => 'required'
        ]);

        $endDate = $request->input('end_date') ?: $request->date;

        // 2. อัปเดตเฉพาะข้อมูลที่เหลือ (ระบบจะไม่แตะต้อง event_code ใน DB)
        $event->update([
            'event_name' => $request->event_name,
            'date'       => $request->date,
            'end_date'   => $endDate,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'location'   => $request->location
        ]);

        return redirect()->route('events.index')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }


    public function destroy(Event $event)
    {

        DB::table('attendance_logs')
            ->where('command_code',$event->event_code)
            ->delete();

        $event->delete();

        return redirect()->route('events.index')->with('success','ลบกิจกรรมสำเร็จ');
    }


    /**
     * เปิดการสแกน (Admin กดเริ่มกิจกรรม)
     */
    public function startScan(Event $event)
    {
        $now = \Carbon\Carbon::now();
        $startDateTime = \Carbon\Carbon::parse($event->date . ' ' . $event->start_time);
        $endDateTime   = \Carbon\Carbon::parse(($event->end_date ?? $event->date) . ' ' . $event->end_time);

        if ($now->lt($startDateTime)) {
            return response()->json(['status' => 'error', 'message' => 'ยังไม่ถึงเวลาเริ่มกิจกรรม'], 422);
        }

        if ($now->gt($endDateTime)) {
            return response()->json(['status' => 'error', 'message' => 'กิจกรรมสิ้นสุดลงแล้ว'], 422);
        }

        $event->update(['is_scanning' => true]);

        return response()->json(['status' => 'success', 'message' => 'เปิดการสแกนแล้ว']);
    }

}