<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id(); // bigint(20) UNSIGNED
            
            // รหัสคำสั่งเริ่มสแกน (สัมพันธ์กับ events.event_code)
            $table->string('command_code', 50)->nullable(); // varchar(50)
            
            // วันที่และเวลาที่มีการตรวจจับใบหน้า
            $table->date('log_date')->nullable(); // date
            $table->time('log_time')->nullable(); // time
            


            // รหัสนักศึกษา (สัมพันธ์กับ users.student_id)
            $table->string('student_id', 20)->nullable(); // varchar(20)

            $table->timestamps(); // สร้าง created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs'); // ✅ แก้ตรงนี้
    }
};