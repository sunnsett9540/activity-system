<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\AttendanceLog;
use Carbon\Carbon;
use App\Http\Controllers\EventController;


/*
|--------------------------------------------------------------------------
| Face Scan API
|--------------------------------------------------------------------------
*/

Route::post('/scan-face', function (Request $request) {

    try {

        $exists = AttendanceLog::where('student_id', $request->student_id)
            ->where('command_code', $request->command_code)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'นักศึกษาเข้าร่วมกิจกรรมนี้แล้ว'
            ], 409);
        }

        $log = AttendanceLog::create([
            'student_id'   => $request->student_id,
            'command_code' => $request->command_code,
            'log_date'     => $request->log_date ?? Carbon::now()->toDateString(),
            'log_time'     => $request->log_time ?? Carbon::now()->toTimeString(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data saved to database'
        ], 201);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);

    }

});


/*
| ดึงข้อมูลการสแกนล่าสุด
*/
Route::get('/scan-list', function () {

    $logs = AttendanceLog::orderBy('id','desc')
        ->limit(10)
        ->get([
            'student_id',
            'command_code',
            'log_date',
            'log_time'
        ]);

    return response()->json([
        'status' => 'success',
        'data'   => $logs
    ]);

});


/*
| ดึงข้อมูลผู้เข้าร่วมกิจกรรม
*/

Route::get('/event-participants/{event_code}', [EventController::class,'getParticipants']);