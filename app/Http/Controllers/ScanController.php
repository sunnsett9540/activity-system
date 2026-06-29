<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScanController extends Controller
{

    /**
     * หน้าเครื่องสแกน
     */
    public function device(Request $request)
    {
        $event_code = $request->event_code;

        if (!$event_code) {
            abort(404, 'ไม่พบรหัสกิจกรรม');
        }

        $event = DB::table('events')->where('event_code', $event_code)->first();
        if (!$event) {
            abort(404, 'ไม่พบรหัสกิจกรรม');
        }

        return view('scan.device', [
            'event' => $event,
            'event_code' => $event_code
        ]);
    }


    /**
     * ฟังก์ชันสแกนหน้า (จำลอง)
     */
    public function scanFace(Request $request)
    {
        try {

            $event_code = $request->event_code;

            if (!$event_code) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ไม่พบรหัสกิจกรรม'
                ]);
            }

            $event = DB::table('events')->where('event_code', $event_code)->first();
            if (!$event) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ไม่พบรหัสกิจกรรม'
                ]);
            }

            $now = Carbon::now();
            $startDate = $event->date;
            $endDate = $event->end_date ?: $event->date;

            $startDateTime = Carbon::parse($startDate . ' ' . $event->start_time);
            $endDateTime = Carbon::parse($endDate . ' ' . $event->end_time);

            if ($now->lt($startDateTime)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ยังไม่ถึงเวลาเริ่มกิจกรรม (รอสแกน)'
                ]);
            }

            if ($now->gt($endDateTime)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'กิจกรรมสิ้นสุดลงแล้ว (หยุดสแกน)'
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | สุ่มเฉพาะ user ที่ยังไม่เคยสแกนในกิจกรรมนี้
            |--------------------------------------------------------------------------
            */

            $user = DB::table('users')
                ->where('role', '!=', 'admin')
                ->whereNotIn('student_id', function ($query) use ($event_code) {

                    $query->select('student_id')
                          ->from('attendance_logs')
                          ->where('command_code', $event_code);

                })
                ->inRandomOrder()
                ->first();


            /*
            |--------------------------------------------------------------------------
            | ถ้าทุกคนสแกนครบแล้ว
            |--------------------------------------------------------------------------
            */

            if (!$user) {
                return response()->json([
                    'status' => 'finished',
                    'message' => 'ทุกคนสแกนครบแล้ว'
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | บันทึกเวลา
            |--------------------------------------------------------------------------
            */

            $now = Carbon::now();

            DB::table('attendance_logs')->insert([
                'command_code' => $event_code,
                'student_id'   => $user->student_id,
                'log_date'     => $now->toDateString(),
                'log_time'     => $now->toTimeString(),
                'created_at'   => $now,
                'updated_at'   => $now
            ]);


            /*
            |--------------------------------------------------------------------------
            | ส่งข้อมูลกลับ realtime
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'status' => 'success',
                'name' => $user->name,
                'student_id' => $user->student_id,
                'time' => $now->format('H:i:s'),
                'message' => 'เช็คอินสำเร็จ'
            ]);


        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาดในระบบ'
            ], 500);
        }
    }
}