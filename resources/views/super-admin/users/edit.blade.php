<x-layouts.super-admin header="Edit Pengguna">
    <form method="POST" action="{{ route('super-admin.users.update', $user) }}" class="max-w-xl">
        @csrf @method('PUT')
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sekolah</label>
                <select name="school_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-- Tanpa Sekolah --</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ $user->school_id == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (kosongkan jika tidak
                    diubah)</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                    class="w-4 h-4 text-indigo-600 rounded">
                <span class="ml-3 text-sm text-gray-700">Aktif</span>
            </label>
            <div class="flex justify-end gap-3">
                <a href="{{ route('super-admin.users.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
            </div>
        </div>
    </form>
</x-layouts.super-admin>
