@extends('layouts.app')

@section('title', 'Data Jenis Pekerjaan - Surya Wijaya')

@section('content')
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Jenis Pekerjaan Baru</h2>
    <form action="{{ route('job-type.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode / Singkatan (Contoh: KPB)</label>
            <input type="text" name="code" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500 uppercase" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan Lengkap</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
        </div>
        <div class="flex justify-end md:justify-start">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow w-full md:w-auto">
                Simpan
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Daftar Jenis Pekerjaan (JP)</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold w-16">No</th>
                    <th class="px-4 py-3 text-left font-semibold w-32">Kode (Singkatan)</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Layanan Lengkap</th>
                    <th class="px-4 py-3 text-center font-semibold w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($jobTypes as $index => $jobType)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-bold text-red-600 uppercase">{{ $jobType->code }}</td>
                        <td class="px-4 py-3">{{ $jobType->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('job-type.destroy', $jobType->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis pekerjaan ini? Data antrean yang sudah menggunakan JP ini mungkin akan terpengaruh jika tidak dibatasi.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada data Jenis Pekerjaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection