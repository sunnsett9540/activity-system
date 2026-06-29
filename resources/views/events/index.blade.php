@extends('layouts.app')

@section('content')

<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">
                <span class="text-blue-600 border-b-4 border-blue-600 pb-1">Events</span>
            </h2>
            <button onclick="openCreateModal()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow-md text-lg font-bold transition-all transform active:scale-95">
                + เพิ่มกิจกรรมใหม่
            </button>
        </div>

        @if(session('success'))
            <div class="bg-white border-l-4 border-green-500 text-green-700 p-5 mb-6 shadow-sm rounded-r-xl font-semibold">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-5 border-b font-bold text-xl text-gray-700 bg-gray-50/50">
                รายการกิจกรรม
            </div>

            <div class="overflow-x-auto">
                @if($events->isEmpty())
                    <div class="p-20 text-center text-gray-400 text-xl font-medium">
                        ยังไม่มีกิจกรรมในระบบ
                    </div>
                @else
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b">
                                <th class="p-4 text-center">Code</th>
                                <th class="p-4 text-left">Event Detail</th>
                                <th class="p-4 text-center">Date & Time</th>
                                <th class="p-4 text-center">Manage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($events as $event)
                           @php
                            // ดึงวันและเวลาปัจจุบันของระบบ
                            $now = \Carbon\Carbon::now();

                            // รวมวันที่และเวลาเริ่มกิจกรรม
                            $startDateTime = \Carbon\Carbon::parse(
                                $event->date . ' ' . $event->start_time
                            );

                            // รวมวันที่และเวลาสิ้นสุดกิจกรรม
                            $endDateTime = \Carbon\Carbon::parse(
                                ($event->end_date ?? $event->date) . ' ' . $event->end_time
                            );

                            // ตรวจสอบสถานะกิจกรรม
                            if ($now->lt($startDateTime)) {

                                // ยังไม่ถึงเวลาเริ่มกิจกรรม
                                $status = 'waiting';

                            } elseif ($now->gte($endDateTime)) {

                                // หมดเวลากิจกรรมแล้ว
                                $status = 'stopped';

                            } else {

                                // กิจกรรมกำลังดำเนินอยู่
                                $status = 'active';
                            }
                        @endphp
                           <tr class="hover:bg-blue-50/30 transition-colors"
                            data-event-id="{{ $event->id }}"
                            data-end="{{ $endDateTime->format('Y-m-d H:i:s') }}">
                                <td class="p-4 text-center">
                                    <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-mono text-lg font-bold border border-blue-100">
                                        {{ $event->event_code }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="text-xl font-bold text-gray-900 mb-0.5">{{ $event->event_name }}</div>
                                    <div class="text-gray-500 text-sm flex items-center">
                                        <span class="mr-1">📍</span> {{ $event->location }}
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="text-lg font-semibold text-gray-800">
                                        @if($event->end_date && $event->end_date !== $event->date)
                                            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                                        @endif
                                    </div>
                                    <div class="text-blue-600 text-sm font-bold">
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <button type="button"
                                            onclick="loadParticipants('{{ $event->event_code }}','{{ $event->event_name }}')"
                                            class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                            ตรวจสอบ
                                        </button>
                                        {{-- ยังไม่ถึงเวลาเริ่มกิจกรรม --}}
                                        @if($status === 'waiting')

                                            <button disabled
                                                class="bg-gray-100 text-gray-400 px-4 py-2 rounded-lg text-sm font-bold cursor-not-allowed border border-gray-200">
                                                ▶ ยังไม่เริ่มกิจกรรม
                                            </button>
                                            {{-- กิจกรรมสิ้นสุดแล้ว --}}
                                            @elseif($status === 'stopped')

                                            <button disabled
                                                class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold cursor-not-allowed">
                                                ⛔ หยุด
                                            </button>
                                            {{-- ถึงเวลาแล้ว สามารถกดเริ่มกิจกรรมได้ --}}
                                            @elseif(!$event->is_scanning)

                                            <button type="button"
                                                onclick="startActivity('{{ $event->id }}', this)"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm">
                                                ▶ เริ่มกิจกรรม
                                            </button>
                                        {{-- เริ่มกิจกรรมแล้ว รอการสแกน --}}
                                            @else

                                            <button id="status-btn-{{ $event->id }}" disabled
                                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold cursor-not-allowed">
                                                📷 รอสแกน
                                            </button>

                                            @endif
                                        <button
                                            onclick="openEditModal(
                                                '{{ $event->id }}',
                                                '{{ $event->event_code }}',
                                                '{{ $event->event_name }}',
                                                '{{ $event->date }}',
                                                '{{ $event->end_date }}',
                                                '{{ $event->start_time }}',
                                                '{{ $event->end_time }}',
                                                '{{ $event->location }}'
                                            )"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm">
                                            แก้ไข
                                        </button>

                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('ยืนยันการลบกิจกรรม?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                                                ลบ
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="participantsModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-4xl rounded-2xl p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 id="modalTitle" class="text-xl font-bold text-gray-800"></h2>
            <button onclick="closeParticipants()" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
        </div>
        <div class="overflow-auto max-h-[60vh]">
            <table class="w-full border-collapse">
                <thead class="bg-gray-50 sticky top-0">
                    <tr class="text-sm text-gray-500">
                        <th class="p-3 border-b text-center font-bold">Time</th>
                        <th class="p-3 border-b text-left font-bold">Student ID</th>
                        <th class="p-3 border-b text-left font-bold">Name</th>
                        <th class="p-3 border-b text-center font-bold">Status</th>
                    </tr>
                </thead>
                <tbody id="logsTable" class="text-md">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-8 shadow-2xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">แก้ไขข้อมูลกิจกรรม</h2>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">รหัสกิจกรรม</label>
                    <input id="edit_code_display" class="border p-2.5 w-full rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed font-mono font-bold" readonly>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">ชื่อกิจกรรม</label>
                    <input id="edit_name" name="event_name" class="border p-2.5 w-full rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none font-medium" required>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">วันที่จัดงาน / วันที่สิ้นสุด</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input id="edit_date" type="date" name="date" class="border p-2 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none text-sm" required>
                        <input id="edit_end_date" type="date" name="end_date" class="border p-2 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none text-sm" placeholder="วันที่สิ้นสุด">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">สถานที่</label>
                    <input id="edit_location" name="location" class="border p-2.5 w-full rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none font-medium" placeholder="สถานที่" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">ช่วงเวลา</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input id="edit_start" type="time" name="start_time" class="border p-2 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none text-sm" required>
                        <input id="edit_end" type="time" name="end_time" class="border p-2 rounded-xl focus:ring-2 focus:ring-yellow-400 outline-none text-sm" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2 rounded-xl border font-bold text-gray-500 hover:bg-gray-50">ยกเลิก</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-yellow-500 text-white font-bold hover:bg-yellow-600 shadow-md transition">บันทึก</button>
            </div>
        </form>
    </div>
</div>

<div id="createModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-8 shadow-2xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">เพิ่มกิจกรรมใหม่</h2>
        <form method="POST" action="{{ route('events.store') }}">
            @csrf
            <div class="space-y-4">
                <input name="event_name" placeholder="ชื่อกิจกรรม" class="border p-3 w-full rounded-xl focus:ring-2 focus:ring-blue-400 outline-none font-medium" required>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">วันที่เริ่มต้น</label>
                        <input type="date" name="date" class="border p-3 w-full rounded-xl focus:ring-2 focus:ring-blue-400 outline-none text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">วันที่สิ้นสุด</label>
                        <input type="date" name="end_date" class="border p-3 w-full rounded-xl focus:ring-2 focus:ring-blue-400 outline-none text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">เวลาเริ่ม</label>
                        <input type="time" name="start_time" class="border p-3 w-full rounded-xl focus:ring-2 focus:ring-blue-400 outline-none text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">เวลาสิ้นสุด</label>
                        <input type="time" name="end_time" class="border p-3 w-full rounded-xl focus:ring-2 focus:ring-blue-400 outline-none text-sm" required>
                    </div>
                </div>
                <input name="location" placeholder="สถานที่จัดงาน" class="border p-3 w-full rounded-xl focus:ring-2 focus:ring-blue-400 outline-none font-medium" required>
            </div>
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeCreateModal()" class="px-5 py-2 rounded-xl border font-bold text-gray-500">ยกเลิก</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-md transition">ยืนยันเพิ่มกิจกรรม</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentEvent = null;
    let refreshInterval = null;
// โหลดรายชื่อผู้เข้าร่วมกิจกรรม
    function loadParticipants(code, name) {
        currentEvent = code;
        document.getElementById("participantsModal").classList.remove("hidden");
        document.getElementById("participantsModal").classList.add("flex");
        document.getElementById("modalTitle").innerHTML = "รายชื่อ : " + name;
        loadLogs();
        if (refreshInterval) clearInterval(refreshInterval);
        refreshInterval = setInterval(loadLogs, 2000);
    }
// โหลดข้อมูลการสแกนจากฐานข้อมูล
    function loadLogs() {
        fetch("/api/event-participants/" + currentEvent)
            .then(res => res.json())
            .then(data => {
                let table = document.getElementById("logsTable");
                table.innerHTML = "";
                data.forEach(log => {
                    let row = `
                        <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                            <td class="p-3 text-center font-bold text-blue-600">${log.log_time}</td>
                            <td class="p-3 font-mono text-sm">${log.student_id}</td>
                            <td class="p-3 font-semibold text-gray-800 uppercase">${log.name ?? '-'}</td>
                            <td class="p-3 text-center">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">มาแล้ว</span>
                            </td>
                        </tr>
                    `;
                    table.innerHTML += row;
                });
            });
    }

    function closeParticipants() {
        document.getElementById("participantsModal").classList.remove("flex");
        document.getElementById("participantsModal").classList.add("hidden");
        if (refreshInterval) clearInterval(refreshInterval);
    }

    function openCreateModal() {
        document.getElementById("createModal").classList.remove("hidden");
        document.getElementById("createModal").classList.add("flex");
    }

    function closeCreateModal() {
        document.getElementById("createModal").classList.add("hidden");
        document.getElementById("createModal").classList.remove("flex");
    }

    // แก้ไขจุด Error 405 ที่นี่
    function openEditModal(id, code, name, date, endDate, start, end, location) {
        document.getElementById("editModal").classList.remove("hidden");
        document.getElementById("editModal").classList.add("flex");
        
        document.getElementById("edit_code_display").value = code;
        document.getElementById("edit_name").value = name;
        document.getElementById("edit_date").value = date;
        document.getElementById("edit_end_date").value = endDate || date;
        document.getElementById("edit_start").value = start;
        document.getElementById("edit_end").value = end;
        document.getElementById("edit_location").value = location;

        // ใส่ ID ลงใน URL ของ Form
        document.getElementById("editForm").action = "/events/" + id;
    }

    function closeEditModal() {
        document.getElementById("editModal").classList.add("hidden");
        document.getElementById("editModal").classList.remove("flex");
    }

    function simulateScan(code) {
        fetch("{{ url('/scan-face') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ event_code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                alert("✔ " + data.name + " (" + data.student_id + ") สแกนสำเร็จ");
                if (currentEvent === code) loadLogs();
            } else if (data.status === "finished") {
                alert("ทุกคนสแกนครบแล้ว");
            } else {
                alert("❌ " + (data.message || "เกิดข้อผิดพลาด"));
            }
        })
        .catch(() => alert("เกิดข้อผิดพลาดในการเชื่อมต่อ"));
    }
// เริ่มกิจกรรมและเปิดระบบสแกน
    function startActivity(id, btn) {
        if (!confirm('เริ่มเปิดการสแกนกิจกรรมนี้?')) return;

        btn.disabled = true;
        btn.textContent = 'กำลังเปิด...';

        fetch(`/events/${id}/start-scan`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                // Reload page so button flips to "สแกน"
                location.reload();
            } else {
                alert("❌ " + data.message);
                btn.disabled = false;
                btn.innerHTML = '▶ เริ่มกิจกรรม';
            }
        })
        .catch(() => {
            alert("เกิดข้อผิดพลาดในการเชื่อมต่อ");
            btn.disabled = false;
            btn.innerHTML = '▶ เริ่มกิจกรรม';
        });
    }

    // Auto-refresh every 60s so "หยุด" state kicks in without manual reload
    // ตรวจสอบเวลาสิ้นสุดกิจกรรมแบบ Real-time
    // เมื่อถึงเวลาสิ้นสุดจะเปลี่ยนจาก "📷 รอสแกน" เป็น "⛔ หยุด"
    setInterval(() => {

    document.querySelectorAll('tr[data-end]').forEach(row => {

        const endTime = new Date(
            row.dataset.end.replace(' ', 'T')
        );

        const now = new Date();

        if (now >= endTime) {

            const id = row.dataset.eventId;
            const btn = document.getElementById('status-btn-' + id);

            if (btn) {
                btn.innerHTML = '⛔ หยุด';

                btn.classList.remove('bg-blue-600');

                btn.classList.add('bg-red-500');

                btn.disabled = true;
            }
        }

    });

}, 1000);
</script>

@endsection