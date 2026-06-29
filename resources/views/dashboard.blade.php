@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-1 gap-6">

    <!-- กล่องข้อมูลผู้ใช้ -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">ข้อมูลผู้ใช้งาน</h3>

        @auth
            <p>ชื่อ: {{ Auth::user()->name }}</p>

            <!-- แสดงสาขา -->
            <p>
                สาขา: 
                {{ Auth::user()->field->field_name ?? '-' }}
            </p>

            <p>รหัสนักศึกษา: {{ Auth::user()->student_id ?? '-' }}</p>

            @if(Auth::user()->role == 'admin')
                <p class="text-red-600 font-bold">สิทธิ์: Admin</p>
            @else
                <p class="text-green-600">สิทธิ์: User</p>
            @endif
        @else
            <p class="text-gray-500">กรุณาเข้าสู่ระบบ</p>
        @endauth
    </div>

</div>


<!-- กิจกรรมล่าสุด -->
<div class="bg-white p-6 rounded-lg shadow mt-6">

    <div class="flex justify-between items-center mb-4">

        <h3 class="text-lg font-bold">กิจกรรมล่าสุด</h3>

    </div>

    @if(isset($events) && $events->count() > 0)

        @foreach($events as $event)
            <div class="border rounded p-4 mb-4">

                <div>
                    <span class="font-bold text-blue-600">
                        {{ $event->event_code }}
                    </span>
                    - {{ $event->event_name }}
                </div>

                <div class="mt-2 text-sm text-gray-700">
                    วันที่ 
                    @if($event->end_date && $event->end_date !== $event->date)
                        {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                    @endif
                    <br>
                    เวลา {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} <br>
                    สถานที่ {{ $event->location }}
                </div>

            </div>
        @endforeach

    @else
        <p class="text-gray-500">ยังไม่มีกิจกรรม</p>
    @endif

</div>

@endsection