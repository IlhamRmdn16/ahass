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
                <p class="text-3xl font-semibold text-gray-800">{{ $totalToday ?? 0 }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
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
                <p class="text-3xl font-semibold text-gray-800">{{ $totalMonth ?? 0 }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
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
                <p class="text-3xl font-semibold text-gray-800">{{ $activeMechanics ?? 0 }} <span class="text-sm font-normal text-gray-500">Orang</span></p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
    <div class="p-4 border-b bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Performa & Distribusi Mekanik</h2>
            <p class="text-xs text-gray-500 mt-1">Grafik jumlah motor yang ditangani oleh masing-masing mekanik aktif.</p>
        </div>
        <form action="{{ route('dashboard.index') }}" method="GET" class="w-full sm:w-auto">
            <select name="filter_date" onchange="this.form.submit()" class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm border p-2 text-sm focus:ring-red-500 focus:border-red-500 font-medium text-gray-700 cursor-pointer bg-white">
                <option value="today" {{ ($filter ?? 'month') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ ($filter ?? 'month') == 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="month" {{ ($filter ?? 'month') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="all" {{ ($filter ?? 'month') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
            </select>
        </form>
    </div>
    <div class="p-6">
        <canvas id="mechanicChart" height="100"></canvas>
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
                @forelse($latestEntries ?? [] as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">
                            {{ \Carbon\Carbon::parse($entry->entry_date)->format('d/m/Y') }} 
                            <span class="text-red-600 font-semibold">{{ \Carbon\Carbon::parse($entry->entry_time)->format('H:i') }}</span>
                        </td>
                        <td class="px-4 py-3 font-bold uppercase">{{ $entry->police_number }}</td>
                        <td class="px-4 py-3">{{ $entry->motor_type }}</td>
                        <td class="px-4 py-3">{{ $entry->mechanic->name ?? '-' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $entry->jobType->code ?? '-' }}</td>
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

<script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        const chartElement = document.getElementById('mechanicChart');
        if(!chartElement) return;

        const ctx = chartElement.getContext('2d');
        
        const aestheticColors = [
            'rgba(220, 38, 38, 0.9)',
            'rgba(55, 65, 81, 0.9)',
            'rgba(153, 27, 27, 0.9)',
            'rgba(17, 24, 39, 0.9)',
            'rgba(239, 68, 68, 0.9)',
            'rgba(75, 85, 99, 0.9)',
            'rgba(248, 113, 113, 0.9)',
            'rgba(31, 41, 55, 0.9)'
        ];

        let delayed;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!},
                datasets: [{
                    label: 'Total Unit',
                    data: {!! json_encode($chartData ?? []) !!},
                    backgroundColor: aestheticColors,
                    borderWidth: 0,
                    borderRadius: 6,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 0;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 150;
                        }
                        return delay;
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.04)',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                family: "'Figtree', sans-serif",
                                size: 12
                            },
                            color: '#6B7280'
                        },
                        border: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: "'Figtree', sans-serif",
                                weight: '600',
                                size: 13
                            },
                            color: '#374151'
                        },
                        border: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.95)',
                        titleFont: { size: 13, family: "'Figtree', sans-serif", weight: 'normal' },
                        bodyFont: { size: 14, family: "'Figtree', sans-serif", weight: 'bold' },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return 'Mekanik: ' + context[0].label;
                            },
                            label: function(context) {
                                return context.parsed.y + ' Unit Diselesaikan';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection