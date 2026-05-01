@extends('layouts.app')

@section('title', 'Unit Entry - Surya Wijaya')

@section('content')
<div x-data="{
    showAddModal: false,
    showEditModal: false,
    editId: '',
    editPoliceNumber: '',
    editMotorType: '',
    editMechanicId: '',
    editJobTypeId: '',
    editPhoneNumber: '',
    editIsDayaAuto: false,
    editReason: '',
    openEditModal(entry) {
        this.editId = entry.id;
        this.editPoliceNumber = entry.police_number;
        this.editMotorType = entry.motor_type;
        this.editMechanicId = entry.mechanic_id;
        this.editJobTypeId = entry.job_type_id;
        this.editPhoneNumber = entry.phone_number || '';
        this.editIsDayaAuto = entry.is_daya_auto == 1;
        this.editReason = entry.reason || '';
        this.showEditModal = true;
    }
}">

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b flex flex-col sm:flex-row justify-between items-start sm:items-center bg-gray-50 gap-4">
            <h2 class="text-lg font-bold text-gray-800">Antrean Hari Ini</h2>
            <div class="flex gap-2 w-full sm:w-auto">
                <button @click="showAddModal = true" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-2 px-4 rounded w-full sm:w-auto text-center shadow">
                    + Tambah Antrean
                </button>
                <a href="{{ route('unit-entry.export-pdf') }}" target="_blank" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-2 px-4 rounded flex items-center justify-center gap-2 w-full sm:w-auto shadow">
                    Lihat PDF
                </a>
            </div>
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
                                <div class="flex items-center justify-center gap-3">
                                    <button @click='openEditModal(@json($entry))' class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                    <form action="{{ route('unit-entry.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus antrean ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                    </form>
                                </div>
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

    <!-- Modal Tambah -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Penambahan py-10 agar tidak mentok atas bawah di mobile -->
        <div class="flex min-h-screen items-center justify-center p-4 py-10 text-center sm:p-0">
            <div x-show="showAddModal" x-transition.opacity @click="showAddModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div x-show="showAddModal" x-transition class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-3xl w-full flex flex-col">
                <form action="{{ route('unit-entry.store') }}" method="POST" class="flex flex-col">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Tambah Antrean Baru</h3>
                            <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Polisi</label>
                                <input type="text" name="police_number" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500 uppercase" required>
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
                            <div class="flex items-center pt-6">
                                <input type="checkbox" name="is_daya_auto" value="1" class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <label class="ml-2 block text-sm text-gray-900 font-medium">Daya Auto</label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                                <input type="text" name="reason" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
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

    <!-- Modal Edit -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Penambahan py-10 agar tidak mentok atas bawah di mobile -->
        <div class="flex min-h-screen items-center justify-center p-4 py-10 text-center sm:p-0">
            <div x-show="showEditModal" x-transition.opacity @click="showEditModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <div x-show="showEditModal" x-transition class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-3xl w-full flex flex-col">
                <form x-bind:action="'{{ url('unit-entry') }}/' + editId" method="POST" class="flex flex-col">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 overflow-y-auto">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Edit Antrean</h3>
                            <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Polisi</label>
                                <input type="text" name="police_number" x-model="editPoliceNumber" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500 uppercase" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Type Motor</label>
                                <input type="text" name="motor_type" x-model="editMotorType" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mekanik</label>
                                <select name="mechanic_id" x-model="editMechanicId" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                                    <option value="">Pilih Mekanik</option>
                                    @foreach($mechanics as $mechanic)
                                        <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pekerjaan (JP)</label>
                                <select name="job_type_id" x-model="editJobTypeId" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                                    <option value="">Pilih JP</option>
                                    @foreach($jobTypes as $job)
                                        <option value="{{ $job->id }}">{{ $job->code }} - {{ $job->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp</label>
                                <input type="text" name="phone_number" x-model="editPhoneNumber" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div class="flex items-center pt-6">
                                <input type="checkbox" name="is_daya_auto" value="1" x-model="editIsDayaAuto" class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <label class="ml-2 block text-sm text-gray-900 font-medium">Daya Auto</label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                                <input type="text" name="reason" x-model="editReason" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end gap-2 border-t mt-auto shrink-0">
                        <button type="button" @click="showEditModal = false" class="bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 font-bold py-2 px-4 rounded shadow-sm">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow-sm">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
