@extends('layouts.app')

@section('title', 'Kelola Pengguna - Surya Wijaya')

@section('content')
<div x-data="{ showModal: false, user: { id: '', name: '', email: '', role: '' } }">
    <div class="bg-white rounded-lg shadow mb-6 p-4">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Pengguna Baru</h2>
        <form action="{{ route('users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required minlength="8">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses (Role)</label>
                <select name="role" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end md:justify-start">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow w-full">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Daftar Pengguna Sistem</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-700 text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-16">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Lengkap</th>
                        <th class="px-4 py-3 text-left font-semibold">Email</th>
                        <th class="px-4 py-3 text-center font-semibold">Hak Akses</th>
                        <th class="px-4 py-3 text-center font-semibold w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-bold">{{ $u->name }}</td>
                            <td class="px-4 py-3">{{ $u->email }}</td>
                            <td class="px-4 py-3 text-center">
                                @php $roleName = $u->roles->first()->name ?? 'Tanpa Role'; @endphp
                                @if($roleName == 'super_admin')
                                    <span class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full">Super Admin</span>
                                @elseif($roleName == 'entry')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">SA / Entry</span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full">Viewer</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center flex justify-center gap-4">
                                <button type="button" @click="user = { id: '{{ $u->id }}', name: '{{ addslashes($u->name) }}', email: '{{ addslashes($u->email) }}', role: '{{ $roleName }}' }; showModal = true;" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium" {{ auth()->id() == $u->id ? 'disabled' : '' }}>Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition.opacity @click="showModal = false" class="fixed inset-0 transition-opacity bg-black bg-opacity-50"></div>

            <div x-show="showModal" x-transition class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <h3 class="text-lg font-bold leading-6 text-gray-900 mb-4">Edit Pengguna</h3>
                <form :action="`{{ url('users') }}/${user.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="user.name" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                        <input type="email" name="email" x-model="user.email" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" minlength="8">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hak Akses (Role)</label>
                        <select name="role" x-model="user.role" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring-red-500 focus:border-red-500" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucwords(str_replace('_', ' ', $role->name)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded shadow">Batal</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
