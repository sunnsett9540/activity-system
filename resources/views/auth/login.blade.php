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
                    <h2 class="text-3xl font-extrabold text-white tracking-tight uppercase">Welcome</h2>
                    <p class="text-slate-400 text-xs mt-3 font-medium">
                        ลงชื่อเข้าใช้เพื่อจัดการกิจกรรมและการเข้าร่วมของคุณ
                    </p>
                </div>

                <div class="relative p-10">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                {{ __('Email Address') }}
                            </label>
                            <input id="email" type="email" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 @error('email') border-red-500 @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="name@engineering.com">

                            @error('email')
                                <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <label for="password" class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                                    {{ __('Password') }}
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="text-xs text-blue-600 hover:underline font-bold" href="{{ route('password.request') }}">
                                        ลืมรหัสผ่าน?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" 
                                   class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 @error('password') border-red-500 @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="••••••••">

                            @error('password')
                                <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center mb-8">
                            <input class="w-5 h-5 text-blue-600 border-gray-300 rounded-lg focus:ring-blue-500 transition cursor-pointer" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="ml-3 text-sm text-gray-500 cursor-pointer select-none font-medium" for="remember">
                                จดจำการเข้าสู่ระบบ
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                            {{ __('Login Now') }}
                        </button>
                        
                        @if (Route::has('register'))
                            <div class="mt-10 text-center border-t border-gray-100 pt-8">
                                <p class="text-gray-400 text-sm font-medium">
                                    ยังไม่มีบัญชีผู้ใช้ใช่หรือไม่? 
                                    <a href="{{ route('register') }}" class="text-blue-600 font-bold hover:text-blue-800 transition">สร้างบัญชีใหม่</a>
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <p class="text-center text-slate-500 text-xs mt-8 uppercase tracking-widest">
                &copy; 2026 Faculty of Engineering
            </p>
        </div>
    </div>
</x-guest-layout>
