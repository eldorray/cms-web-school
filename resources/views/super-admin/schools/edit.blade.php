<x-layouts.super-admin header="Edit Sekolah">
    <form method="POST" action="{{ route('super-admin.schools.update', $school) }}" class="max-w-2xl">
        @csrf @method('PUT')
        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                    <input type="text" name="name" value="{{ old('name', $school->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Domain</label>
                    <input type="text" name="domain" value="{{ old('domain', $school->domain) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $school->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $school->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $school->tagline) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <textarea name="address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('address', $school->address) }}</textarea>
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
