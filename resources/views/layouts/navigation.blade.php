<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Side -->
            <div class="flex items-center space-x-10">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}"
                   class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                    Activity System
                </a>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex space-x-6">

                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link
                        :href="route('events.index')"
                        :active="request()->routeIs('events.*')">
                        Events
                    </x-nav-link>

                    <!-- Students Menu -->
                    <x-nav-link
                        :href="route('students.index')"
                        :active="request()->routeIs('students.*')">
                        Students
                    </x-nav-link>

                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex items-center text-sm text-gray-600">
                Demo User
            </div>

            <!-- Mobile Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
         class="hidden sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1 px-4">

            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link
                :href="route('events.index')"
                :active="request()->routeIs('events.*')">
                Events
            </x-responsive-nav-link>

            <!-- Students Mobile -->
            <x-responsive-nav-link
                :href="route('students.index')"
                :active="request()->routeIs('students.*')">
                Students
            </x-responsive-nav-link>

        </div>

        <div class="px-4 py-3 border-t border-gray-200 text-sm text-gray-600">
            Demo User
        </div>
    </div>
</nav>