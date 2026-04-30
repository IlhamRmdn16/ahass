@extends('layouts.app')

@section('title', 'Unit Entry - Surya Wijaya')

@section('content')
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <form action="{{ route('unit-entry.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. Polisi</label>
            <input type="text" name="police_number" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type Motor</label>
            <input type="text" name="motor_type" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mekanik</label>
            <select name="mechanic_id" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                <option value="">Pilih Mekanik</option>
                @foreach($mechanics as $mechanic)
                    <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pekerjaan (JP)</label>
            <select name="job_type_id" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                <option value="">Pilih JP</option>
                @foreach($jobTypes as $job)
                    <option value="{{ $job->id }}">{{ $job->code }} - {{ $job->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp</label>
            <input type="text" name="phone_number" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
        </div>
        <div class="flex items-center h-10">
            <input type="checkbox" name="is_daya_auto" value="1" class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
            <label class="ml-2 block text-sm text-gray-900 font-medium">Daya Auto</label>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
            <input type="text" name="reason" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
        </div>
        <div class="md:col-span-4 flex justify-end mt-2">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow">
                Simpan & Lanjut
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b flex justify-between items-center bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Antrean Hari Ini</h2>
        <a href="{{ route('unit-entry.export-pdf') }}" target="_blank" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-1.5 px-4 rounded flex items-center gap-2">
            Lihat PDF
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">No. Polisi</th>
                    <th class="px-4 py-3 text-left font-semibold">Type Motor</th>
                    <th class="px-4 py-3 text-left font-semibold">Jam</th>
                    <th class="px-4 py-3 text-left font-semibold">Mekanik</th>
                    <th class="px-4 py-3 text-left font-semibold">JP</th>
                    <th class="px-4 py-3 text-left font-semibold">No. Telp</th>
                    <th class="px-4 py-3 text-center font-semibold">Daya Auto</th>
                    <th class="px-4 py-3 text-left font-semibold">Alasan</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($entries as $index => $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-bold uppercase">{{ $entry->police_number }}</td>
                        <td class="px-4 py-3">{{ $entry->motor_type }}</td>
                        <td class="px-4 py-3 text-red-600 font-semibold">{{ \Carbon\Carbon::parse($entry->entry_time)->format('H:i') }}</td>
                        <td class="px-4 py-3">{{ $entry->mechanic->name }}</td>
                        <td class="px-4 py-3 font-medium">{{ $entry->jobType->code }}</td>
                        <td class="px-4 py-3">{{ $entry->phone_number ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($entry->is_daya_auto)
                                <span class="text-green-600 font-bold">✓</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $entry->reason ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('unit-entry.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus antrean ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-4 py-8 text-center text-gray-500">Belum ada antrean hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection