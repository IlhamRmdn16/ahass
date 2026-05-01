@extends('layouts.app')

@section('title', 'Data Jenis Pekerjaan - Surya Wijaya')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    jobType: { id: '', code: '', name: '' } 
}">

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50 gap-4">
            <h2 class="text-lg font-bold text-gray-800">Daftar Jenis Pekerjaan (JP)</h2>
            <button @click="showAddModal = true" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded w-full sm:w-auto text-center shadow">
                + Tambah JP
            </button>
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
                    @forelse($jobTypes as $index => $jt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-bold text-red-600 uppercase">{{ $jt->code }}</td>
                            <td class="px-4 py-3">{{ $jt->name }}</td>
                            <td class="px-4 py-3 text-center flex justify-center gap-4">
                                <button type="button" @click="jobType = { id: '{{ $jt->id }}', code: '{{ addslashes($jt->code) }}', name: '{{ addslashes($jt->name) }}' }; showEditModal = true;" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('job-type.destroy', $jt->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis pekerjaan ini? Data antrean yang sudah menggunakan JP ini mungkin akan terpengaruh jika tidak dibatasi.');">
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

    <!-- Modal Tambah JP -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4 py-10 text-center sm:p-0">
            <div x-show="showAddModal" x-transition.opacity @click="showAddModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div x-show="showAddModal" x-transition class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full flex flex-col">
                <form action="{{ route('job-type.store') }}" method="POST" class="flex flex-col">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Tambah Jenis Pekerjaan</h3>
                            <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode / Singkatan (Contoh: KPB)</label>
                                <input type="text" name="code" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500 uppercase" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan Lengkap</label>
                                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end gap-2 border-t mt-auto shrink-0">
                        <button type="button" @click="showAddModal = false" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-bold py-2 px-4 rounded shadow-sm">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit JP -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 py-10 text-center sm:p-0">
            <div x-show="showEditModal" x-transition.opacity @click="showEditModal = false" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <div x-show="showEditModal" x-transition class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full flex flex-col">
                <form x-bind:action="'{{ url('job-type') }}/' + jobType.id" method="POST" class="flex flex-col">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Edit Jenis Pekerjaan</h3>
                            <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode / Singkatan</label>
                                <input type="text" name="code" x-model="jobType.code" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500 uppercase" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan Lengkap</label>
                                <input type="text" name="name" x-model="jobType.name" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end gap-2 border-t mt-auto shrink-0">
                        <button type="button" @click="showEditModal = false" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-bold py-2 px-4 rounded shadow-sm">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection