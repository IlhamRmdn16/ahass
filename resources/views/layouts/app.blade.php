<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Surya Wijaya')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-red-600 text-white p-4 flex justify-between items-center shadow">
            <div class="flex items-center gap-3">
                <div class="bg-white text-red-600 font-bold p-2 rounded-full h-10 w-10 flex items-center justify-center">SW</div>
                <h1 class="text-xl font-bold tracking-wider">SURYA WIJAYA</h1>
            </div>
            <div class="text-sm font-medium">
                {{ now()->translatedFormat('l, d F Y | H:i') }}
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            <aside class="w-64 bg-white shadow-md hidden md:block border-r">
                <nav class="p-4 flex flex-col gap-2">
                    <a href="{{ route('dashboard.index') }}" class="p-2 {{ request()->routeIs('dashboard.*') || request()->is('/') ? 'bg-red-50 text-red-600 rounded font-medium border-l-4 border-red-600' : 'hover:bg-gray-100 rounded text-gray-700 font-medium' }}">Dashboard</a>
                    <a href="{{ route('unit-entry.index') }}" class="p-2 {{ request()->routeIs('unit-entry.*') ? 'bg-red-50 text-red-600 rounded font-medium border-l-4 border-red-600' : 'hover:bg-gray-100 rounded text-gray-700 font-medium' }}">Unit Entry</a>
                    
                    <div class="pt-4 pb-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider px-2">Master Data</p>
                    </div>
                    
                    <a href="{{ route('mechanic.index') }}" class="p-2 {{ request()->routeIs('mechanic.*') ? 'bg-red-50 text-red-600 rounded font-medium border-l-4 border-red-600' : 'hover:bg-gray-100 rounded text-gray-700 font-medium' }}">Data Mekanik</a>
                    <a href="{{ route('job-type.index') }}" class="p-2 {{ request()->routeIs('job-type.*') ? 'bg-red-50 text-red-600 rounded font-medium border-l-4 border-red-600' : 'hover:bg-gray-100 rounded text-gray-700 font-medium' }}">Data Jenis Pekerjaan</a>
                    
                    <div class="pt-4 pb-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider px-2">Laporan</p>
                    </div>
                    
                    <a href="{{ route('history.index') }}" class="p-2 {{ request()->routeIs('history.*') ? 'bg-red-50 text-red-600 rounded font-medium border-l-4 border-red-600' : 'hover:bg-gray-100 rounded text-gray-700 font-medium' }}">Riwayat Servis</a>
                </nav>
            </aside>

            <main class="flex-1 p-4 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>