@extends('layouts.app')

@section('title', 'Data Mekanik - Surya Wijaya')

@section('content')
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Mekanik Baru</h2>
    <form action="{{ route('mechanic.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
        @csrf
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mekanik</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
        </div>
        <div class="flex items-center h-10 mb-1 md:mb-0">
            <input type="checkbox" name="is_active" value="1" checked class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
            <label class="ml-2 block text-sm text-gray-900 font-medium mr-4">Aktif Bekerja</label>
        </div>
        <div>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow w-full md:w-auto">
                Simpan
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Daftar Mekanik</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold w-16">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Mekanik</th>
                    <th class="px-4 py-3 text-center font-semibold w-32">Status</th>
                    <th class="px-4 py-3 text-center font-semibold w-64">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($mechanics as $index => $mechanic)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-medium">{{ $mechanic->name }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($mechanic->is_active)
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center flex justify-center gap-4">
                            <form action="{{ route('mechanic.update', $mechanic->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $mechanic->name }}">
                                <input type="hidden" name="is_active" value="{{ $mechanic->is_active ? '0' : '1' }}">
                                <button type="submit" class="text-blue-600 hover:text-blue-800 font-medium">Ubah Status</button>
                            </form>
                            <span class="text-gray-300">|</span>
                            <form action="{{ route('mechanic.destroy', $mechanic->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mekanik ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada data mekanik.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection