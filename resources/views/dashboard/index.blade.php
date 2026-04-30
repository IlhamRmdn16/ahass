@extends('layouts.app')

@section('title', 'Dashboard - Surya Wijaya')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Ringkasan Bengkel</h2>
    <p class="text-gray-500">Pantau performa layanan unit entry AHASS Surya Wijaya.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Antrean Hari Ini</p>
                <p class="text-3xl font-semibold text-gray-800">{{ $totalToday }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Total Bulan Ini</p>
                <p class="text-3xl font-semibold text-gray-800">{{ $totalMonth }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600">Mekanik Aktif</p>
                <p class="text-3xl font-semibold text-gray-800">{{ $activeMechanics }} <span class="text-sm font-normal text-gray-500">Orang</span></p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-800">5 Antrean Terakhir</h2>
        <a href="{{ route('unit-entry.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">Lihat Semua &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Waktu</th>
                    <th class="px-4 py-3 text-left font-semibold">No. Polisi</th>
                    <th class="px-4 py-3 text-left font-semibold">Type Motor</th>
                    <th class="px-4 py-3 text-left font-semibold">Mekanik</th>
                    <th class="px-4 py-3 text-left font-semibold">JP</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($latestEntries as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">
                            {{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }} 
                            <span class="text-red-600 font-semibold">{{ \Carbon\Carbon::parse($entry->entry_time)->format('H:i') }}</span>
                        </td>
                        <td class="px-4 py-3 font-bold uppercase">{{ $entry->police_number }}</td>
                        <td class="px-4 py-3">{{ $entry->motor_type }}</td>
                        <td class="px-4 py-3">{{ $entry->mechanic->name }}</td>
                        <td class="px-4 py-3 font-medium">{{ $entry->jobType->code }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data antrean.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection