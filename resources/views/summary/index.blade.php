@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-6">
            จัดการกิจกรรม
        </h2>

        {{-- ปุ่มเพิ่มกิจกรรม (เฉพาะ admin) --}}
        @if(Auth::user()->role == 'admin')
        <a href="{{ route('events.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded">
           เพิ่มกิจกรรม
        </a>
        @endif

        <table class="min-w-full border border-gray-200 mt-4">
            <thead>
                <tr class="bg-gray-100 text-center">
                    <th class="border px-4 py-2">รหัส</th>
                    <th class="border px-4 py-2">ชื่อกิจกรรม</th>
                    <th class="border px-4 py-2">วันที่</th>
                    <th class="border px-4 py-2">เวลา</th>

                    {{-- แสดงคอลัมน์นี้เฉพาะ admin --}}
                    @if(Auth::user()->role == 'admin')
                    <th class="border px-4 py-2">จัดการ</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach($events as $event)
                <tr class="text-center">

                    <td class="border px-4 py-2">{{ $event->event_code }}</td>
                    <td class="border px-4 py-2">{{ $event->event_name }}</td>
                    <td class="border px-4 py-2">{{ $event->date }}</td>
                    <td class="border px-4 py-2">{{ $event->start_time }}</td>

                    {{-- ปุ่มแก้ไข เฉพาะ admin --}}
                    @if(Auth::user()->role == 'admin')
                    <td class="border px-4 py-2">

                        <a href="{{ route('events.edit',$event->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                           แก้ไข
                        </a>

                        <form action="{{ route('events.destroy',$event->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-3 py-1 rounded">
                                ลบ
                            </button>
                        </form>

                    </td>
                    @endif

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection