<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Surya Wijaya')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('image/icon.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ isMobileOpen: false, isPinned: true, isHovered: false }" class="min-h-screen flex flex-col overflow-hidden">

        <header class="bg-red-600 text-white p-4 flex justify-between items-center shadow z-40 relative">
            <div class="flex items-center">
                <div class="bg-white p-1.5 rounded flex items-center justify-center shadow-sm">
                    <img src="{{ asset('image/logo.webp') }}" alt="Logo Surya Wijaya" class="h-7 sm:h-9 w-auto object-contain">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-sm font-medium hidden md:block"
                     x-data="{
                        currentTime: '',
                        updateClock() {
                            const now = new Date();
                            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                            const datePart = now.toLocaleDateString('id-ID', optionsDate);

                            const hours = String(now.getHours()).padStart(2, '0');
                            const minutes = String(now.getMinutes()).padStart(2, '0');

                            this.currentTime = `${datePart} | ${hours}:${minutes} WIB`;
                        }
                     }"
                     x-init="updateClock(); setInterval(() => updateClock(), 1000)"
                     x-text="currentTime">
                </div>

                <div class="hidden md:block h-6 w-px bg-red-400 mx-2"></div>

                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-800 hover:bg-red-900 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Tombol menu hamburger disembunyikan untuk role entry -->
                @hasanyrole('super_admin|viewer')
                <button @click="isMobileOpen = !isMobileOpen" class="md:hidden p-2 bg-red-700 hover:bg-red-800 rounded text-white focus:outline-none transition">
                    <svg x-show="!isMobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="isMobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                @endhasanyrole
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden relative">

            <!-- Sidebar & Backdrop disembunyikan untuk role entry -->
            @hasanyrole('super_admin|viewer')
            <div x-show="isMobileOpen" x-transition.opacity @click="isMobileOpen = false" x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"></div>

            <aside
                @mouseenter="isHovered = true"
                @mouseleave="isHovered = false"
                :class="{
                    'translate-x-0': isMobileOpen,
                    '-translate-x-full': !isMobileOpen,
                    'md:translate-x-0': true,
                    'md:w-64': isPinned || isHovered,
                    'md:w-20': !isPinned && !isHovered
                }"
                class="fixed inset-y-0 left-0 top-[72px] md:top-0 z-30 bg-white shadow-xl md:shadow-md border-r transition-all duration-300 flex flex-col md:relative overflow-hidden w-64"
            >
                <div class="hidden md:flex justify-end p-3 border-b border-gray-100">
                    <button @click="isPinned = !isPinned" class="text-gray-400 hover:text-red-600 focus:outline-none transition">
                        <svg x-show="!isPinned" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"></circle></svg>
                        <svg x-show="isPinned" x-cloak class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"></circle></svg>
                    </button>
                </div>

                <nav class="p-3 flex flex-col gap-2 overflow-y-auto">

                    @hasanyrole('super_admin|viewer')
                    <a href="{{ route('dashboard.index') }}" class="flex items-center p-2 rounded transition-colors whitespace-nowrap {{ request()->routeIs('dashboard.*') ? 'bg-red-50 text-red-600 font-medium border-l-4 border-red-600' : 'text-gray-600 hover:bg-gray-100 font-medium border-l-4 border-transparent' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span :class="{ 'opacity-100 w-auto ml-3': isPinned || isHovered, 'opacity-0 w-0 ml-0': !isPinned && !isHovered }" class="transition-all duration-300">Dashboard</span>
                    </a>
                    @endhasanyrole

                    @hasanyrole('super_admin|entry')
                    <a href="{{ route('unit-entry.index') }}" class="flex items-center p-2 rounded transition-colors whitespace-nowrap {{ request()->routeIs('unit-entry.*') ? 'bg-red-50 text-red-600 font-medium border-l-4 border-red-600' : 'text-gray-600 hover:bg-gray-100 font-medium border-l-4 border-transparent' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span :class="{ 'opacity-100 w-auto ml-3': isPinned || isHovered, 'opacity-0 w-0 ml-0': !isPinned && !isHovered }" class="transition-all duration-300">Unit Entry</span>
                    </a>
                    @endhasanyrole

                    @role('super_admin')
                    <div :class="{ 'opacity-100 h-8 pt-4': isPinned || isHovered, 'opacity-0 h-0 pt-0': !isPinned && !isHovered }" class="transition-all duration-300 overflow-hidden">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-2 whitespace-nowrap">Master Data</p>
                    </div>

                    <a href="{{ route('users.index') }}" class="flex items-center p-2 rounded transition-colors whitespace-nowrap {{ request()->routeIs('users.*') ? 'bg-red-50 text-red-600 font-medium border-l-4 border-red-600' : 'text-gray-600 hover:bg-gray-100 font-medium border-l-4 border-transparent' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span :class="{ 'opacity-100 w-auto ml-3': isPinned || isHovered, 'opacity-0 w-0 ml-0': !isPinned && !isHovered }" class="transition-all duration-300">Kelola Pengguna</span>
                    </a>

                    <a href="{{ route('mechanic.index') }}" class="flex items-center p-2 rounded transition-colors whitespace-nowrap {{ request()->routeIs('mechanic.*') ? 'bg-red-50 text-red-600 font-medium border-l-4 border-red-600' : 'text-gray-600 hover:bg-gray-100 font-medium border-l-4 border-transparent' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span :class="{ 'opacity-100 w-auto ml-3': isPinned || isHovered, 'opacity-0 w-0 ml-0': !isPinned && !isHovered }" class="transition-all duration-300">Data Mekanik</span>
                    </a>

                    <a href="{{ route('job-type.index') }}" class="flex items-center p-2 rounded transition-colors whitespace-nowrap {{ request()->routeIs('job-type.*') ? 'bg-red-50 text-red-600 font-medium border-l-4 border-red-600' : 'text-gray-600 hover:bg-gray-100 font-medium border-l-4 border-transparent' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span :class="{ 'opacity-100 w-auto ml-3': isPinned || isHovered, 'opacity-0 w-0 ml-0': !isPinned && !isHovered }" class="transition-all duration-300">Data JP</span>
                    </a>
                    @endrole

                    @hasanyrole('super_admin|viewer')
                    <div :class="{ 'opacity-100 h-8 pt-4': isPinned || isHovered, 'opacity-0 h-0 pt-0': !isPinned && !isHovered }" class="transition-all duration-300 overflow-hidden">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-2 whitespace-nowrap">Laporan</p>
                    </div>

                    <a href="{{ route('history.index') }}" class="flex items-center p-2 rounded transition-colors whitespace-nowrap {{ request()->routeIs('history.*') ? 'bg-red-50 text-red-600 font-medium border-l-4 border-red-600' : 'text-gray-600 hover:bg-gray-100 font-medium border-l-4 border-transparent' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span :class="{ 'opacity-100 w-auto ml-3': isPinned || isHovered, 'opacity-0 w-0 ml-0': !isPinned && !isHovered }" class="transition-all duration-300">Riwayat Servis</span>
                    </a>
                    @endhasanyrole

                </nav>
            </aside>
            @endhasanyrole

            <main class="flex-1 p-4 overflow-y-auto">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-transition.duration.500ms x-init="setTimeout(() => show = false, 3000)" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
                            <div class="flex items-center gap-2 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ session('success') }}
                            </div>
                            <button @click="show = false" class="text-green-700 hover:text-green-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif
                @yield('content')
            </main>

        </div>
    </div>
</body>
</html>
