@extends('layouts.app')

@section('content')

<div class="container mx-auto py-10 px-6">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        
        <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-100 px-8 py-6 flex justify-between items-center">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                สรุปกิจกรรม
            </h2>
            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase">
                ทั้งหมด {{ count($events) }} รายการ
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 border-b border-gray-200 text-center text-sm font-bold text-gray-700 uppercase">รหัส</th>
                        <th class="px-6 py-4 border-b border-gray-200 text-left text-sm font-bold text-gray-700 uppercase">ชื่อกิจกรรม</th>
                        <th class="px-6 py-4 border-b border-gray-200 text-center text-sm font-bold text-gray-700 uppercase">วันที่ / เวลา</th>
                        <th class="px-6 py-4 border-b border-gray-200 text-left text-sm font-bold text-gray-700 uppercase">สถานที่</th>
                        <th class="px-6 py-4 border-b border-gray-200 text-center text-sm font-bold text-gray-700 uppercase">สถานะการเข้าร่วม</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach($events as $event)
                        <tr class="hover:bg-blue-50/30 transition-colors duration-200">

                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                                    {{ $event->event_code }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-base font-semibold text-gray-900">
                                    {{ $event->event_name }}
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-800">
                                    @if($event->end_date && $event->end_date !== $event->date)
                                        {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} น.
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0
                                            l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $event->location }}
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">

                                {{-- ถ้ามีข้อมูลใน attendance_logs --}}
                                @if($event->status == 'เข้าร่วม')

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-green-100 text-green-700 ring-1 ring-green-600/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                                        เข้าร่วมแล้ว
                                    </span>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black bg-gray-100 text-gray-600 ring-1 ring-gray-600/20">
                                        รอประกาศ
                                    </span>

                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection