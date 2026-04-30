@extends('layouts.app')

@section('title', 'Arsip Riwayat - Surya Wijaya')

@section('content')
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Filter Periode Riwayat</h2>
    <form action="{{ route('history.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow w-full">
                Tampilkan Riwayat
            </button>
            <a href="{{ route('history.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded shadow text-center">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Daftar Arsip Harian</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-center font-semibold">Total Konsumen</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($histories as $history)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($history->entry_date)->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold">
                                {{ $history->total }} Unit
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('history.pdf', $history->entry_date) }}" class="text-red-600 hover:text-red-900 font-bold flex items-center gap-1">
                                    Lihat PDF
                                </a>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('history.destroy', $history->entry_date) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus data tanggal ini akan menghapus SELURUH ({{ $history->total }}) data konsumen pada hari tersebut secara permanen. Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                            Tidak ada riwayat ditemukan untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $histories->links() }}
    </div>
</div>
@endsection