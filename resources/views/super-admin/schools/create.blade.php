<x-layouts.super-admin header="Tambah Sekolah">
    <form method="POST" action="{{ route('super-admin.schools.store') }}" class="max-w-2xl">
        @csrf
        <div class="space-y-6">
            <!-- School Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi Sekolah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Domain *</label>
                        <input type="text" name="domain" value="{{ old('domain') }}" required
                            placeholder="sdn1.sekolah.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('domain')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Admin User -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Admin Sekolah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Admin *</label>
                        <input type="text" name="admin_name" value="{{ old('admin_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Admin *</label>
                        <input type="email" name="admin_email" value="{{ old('admin_email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('admin_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <input type="password" name="admin_password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('super-admin.schools.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Simpan</button>
            </div>
        </div>
    </form>
</x-layouts.super-admin>
