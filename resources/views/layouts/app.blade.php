<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Activity Management System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=nunito:400,600,700&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased bg-gray-100 text-lg">

<div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl flex-shrink-0">

        <div class="p-6">
            <h3 class="text-2xl font-extrabold tracking-tight flex items-center">
                <span class="bg-blue-600 p-2 rounded-lg mr-2 text-sm shadow-lg shadow-blue-500/20">EN</span>
                Engineering
            </h3>
        </div>

        <nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto">

            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 rounded-xl transition-all
               {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2 7-7 7 7 2 2M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3"/>
                </svg>
                Dashboard
            </a>

            @auth
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('events.index') }}"
                   class="flex items-center px-4 py-3 rounded-xl transition-all
                   {{ request()->routeIs('events.*') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Events
                </a>
                @endif
            @endauth

            @auth
                @if(Auth::user()->role !== 'admin')
                <a href="{{ route('summary') }}"
                   class="flex items-center px-4 py-3 rounded-xl transition-all
                   {{ request()->routeIs('summary') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-2m3 2v-4m3 2v-6"/>
                    </svg>
                    สรุปกิจกรรม
                </a>
                @endif
            @endauth

        </nav>

        <div class="p-4 bg-slate-950/50 border-t border-slate-800 mt-auto">

            @auth
            <div class="flex items-center mb-4 px-2">

                <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-blue-400 rounded-full flex items-center justify-center text-sm font-bold shadow-inner mr-3 ring-2 ring-slate-800">
                    {{ substr(Auth::user()->name,0,2) }}
                </div>

                <div class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-[10px] text-blue-400 font-bold uppercase tracking-widest">
                        {{ Auth::user()->role }}
                    </p>
                </div>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2.5 bg-red-500/10 text-red-500 border border-red-500/20 rounded-xl hover:bg-red-500 hover:text-white transition-all duration-300 font-bold text-sm">
                    ออกจากระบบ
                </button>
            </form>

            @else

            <a href="{{ route('login') }}"
               class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition">
                เข้าสู่ระบบ
            </a>

            @endauth

        </div>

    </aside>

    <main class="flex-1 flex flex-col overflow-hidden bg-gray-100">

        <header class="h-4 shrink-0"></header>

        <div class="flex-1 overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>

    </main>

</div>

</body>
</html>