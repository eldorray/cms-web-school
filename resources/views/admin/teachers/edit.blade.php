<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.teachers.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Guru/Staff</h1>
        </div>

        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" enctype="multipart/form-data"
            class="max-w-2xl">
            @csrf @method('PUT')
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $teacher->name) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="nip"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIP</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $teacher->nip) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="nuptk"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NUPTK</label>
                        <input type="text" name="nuptk" id="nuptk" value="{{ old('nuptk', $teacher->nuptk) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="position"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jabatan</label>
                        <select name="position" id="position" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            @foreach ($positions as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('position', $teacher->position) == $key ? 'selected' : '' }}>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="position_detail"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Detail
                            Jabatan</label>
                        <input type="text" name="position_detail" id="position_detail"
                            value="{{ old('position_detail', $teacher->position_detail) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="subject"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mata
                            Pelajaran</label>
                        <input type="text" name="subject" id="subject"
                            value="{{ old('subject', $teacher->subject) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="education"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pendidikan</label>
                        <input type="text" name="education" id="education"
                            value="{{ old('education', $teacher->education) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $teacher->phone) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $teacher->email) }}"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="bio"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Biodata</label>
                    <textarea name="bio" id="bio" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('bio', $teacher->bio) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto</label>
                    @if ($teacher->getFirstMediaUrl('photo'))
                        <div class="mb-3"><img src="{{ $teacher->getFirstMediaUrl('photo') }}"
                                class="w-24 h-24 rounded-lg object-cover"></div>
                    @endif
                    <input type="file" name="photo" id="photo" accept="image/*"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                </label>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.teachers.index') }}"
                        class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>
