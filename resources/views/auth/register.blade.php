<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 px-4 py-12">
        
        <div class="w-full max-w-md">
            <div class="relative bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-slate-800/60">
                
                <div class="absolute -top-24 -right-24 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-32 -left-32 w-52 h-52 bg-sky-400/10 rounded-full blur-3xl"></div>

                <div class="relative bg-slate-900 p-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-tr from-blue-600 to-sky-400 rounded-3xl mb-5 shadow-xl shadow-blue-500/30 transform -rotate-6">
                        <span class="text-white text-3xl font-extrabold uppercase tracking-tight">En</span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight uppercase">Create Account</h2>
                    <p class="text-slate-400 text-xs mt-3 font-medium">
                        สร้างบัญชีใหม่เพื่อเข้าใช้งานระบบกิจกรรมและการเข้าร่วมของคุณ
                    </p>
                </div>

                <div class="relative p-10">
                    <form id="regForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                {{ __('Name') }}
                            </label>
                            <input id="name" type="text" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 @error('name') border-red-500 @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                   placeholder="ชื่อ-นามสกุล">
                            @error('name')
                                <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="student_id" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                Student ID
                            </label>

                            <input id="student_id" type="text"
                                class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 @error('student_id') border-red-500 @enderror"
                                name="student_id"
                                value="{{ old('student_id') }}"
                                required
                                placeholder="รหัสนักศึกษา">

                            @error('student_id')
                                <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                สาขา
                            </label>
                            <select name="field_id"
                                    class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 text-gray-700">

                                <option value="1">วิศวกรรมคอมพิวเตอร์</option>
                                <option value="2">วิศวกรรมไฟฟ้า</option>
                                <option value="3">วิศวกรรมโยธา</option>
                                <option value="4">วิศวกรรมเครื่องกล</option>
                                <option value="5">วิศวกรรมอุตสาหการ</option>
                                <option value="6">วิศวกรรมโลจิสติกส์</option>
                                
                            </select>
                        </div>
                        <div class="mb-6">
                            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                {{ __('Email Address') }}
                            </label>
                            <input id="email" type="email" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 @error('email') border-red-500 @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="name@engineering.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                {{ __('Password') }}
                            </label>
                            <input id="password" type="password" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 @error('password') border-red-500 @enderror" 
                                   name="password" required autocomplete="new-password"
                                   placeholder="••••••••">
                            @error('password')
                                <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label for="password-confirm" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                {{ __('Confirm Password') }}
                            </label>
                            <input id="password-confirm" type="password" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••">
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                            {{ __('Register Now') }}
                        </button>
                        
                        <div class="mt-8 text-center border-t border-gray-100 pt-6">
                            <p class="text-gray-400 text-sm font-medium">
                                มีบัญชีผู้ใช้แล้วใช่หรือไม่? 
                                <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:text-blue-800 transition">เข้าสู่ระบบ</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center text-slate-500 text-xs mt-8 uppercase tracking-widest">
                &copy; 2026 Faculty of Engineering
            </p>
        </div>
    </div>
</x-guest-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // อ้างอิงถึงฟอร์มที่มี id="regForm"
        const form = document.getElementById('regForm');

        if (form) {
            form.addEventListener('submit', function (e) {
                // หยุดการ Submit ของฟอร์มไว้ก่อน
                e.preventDefault();

                // แสดงป๊อปอัปแจ้งเตือน
                Swal.fire({
                    title: 'ขออนุญาตใช้ข้อมูลใบหน้าเพื่อยืนยันตัวตน',
                    text: "ระบบต้องการขออนุญาตเข้าถึงใบหน้าของคุณเพื่อใช้ในการยืนยันตัวตนและบันทึกการเข้าร่วมกิจกรรม",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#075aad', // สีน้ำเงินหลักของ UI คุณ
                    cancelButtonColor: '#94a3b8', // สี slate-400
                    confirmButtonText: 'อนุญาตและสมัครสมาชิก',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true,
                    borderRadius: '1.5rem', // ความมนระดับเดียวกับ UI หลัก
                    customClass: {
                        popup: 'rounded-3xl' // บังคับให้ขอบมนขึ้นอีก
                    }
                }).then((result) => {
                    // ถ้าผู้ใช้คลิกปุ่ม "อนุญาต..."
                    if (result.isConfirmed) {
                        form.submit(); // ส่งข้อมูลไปที่ Database จริงๆ
                    }
                });
            });
        }
    });
</script>