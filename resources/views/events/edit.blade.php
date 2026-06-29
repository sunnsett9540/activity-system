@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4 text-yellow-600">
            แก้ไขกิจกรรม
        </h2>

        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>รหัสกิจกรรม</label>
                <input type="text" name="event_code"
                       value="{{ $event->event_code }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label>ชื่อกิจกรรม</label>
                <input type="text" name="event_name"
                       value="{{ $event->event_name }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label>วันที่</label>
                <input type="date" name="date"
                       value="{{ $event->date }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-3">
                <label>วันที่สิ้นสุด</label>
                <input type="date" name="end_date"
                       value="{{ $event->end_date }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label>เวลาเริ่ม</label>
                    <input type="time" name="start_time"
                           value="{{ $event->start_time }}"
                           class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label>เวลาสิ้นสุด</label>
                    <input type="time" name="end_time"
                           value="{{ $event->end_time }}"
                           class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mb-4">
                <label>สถานที่</label>
                <input type="text" name="location"
                       value="{{ $event->location }}"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('events.index') }}"
                   class="bg-gray-400 text-white px-4 py-2 rounded">
                    ยกเลิก
                </a>

                <button type="submit"
                        class="bg-yellow-500 text-white px-4 py-2 rounded">
                    อัปเดต
                </button>
            </div>
        </form>

    </div>
</div>

@endsection