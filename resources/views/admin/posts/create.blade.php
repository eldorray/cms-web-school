<x-layouts.app>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.posts.index') }}"
                class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                @svg('fas-arrow-left', 'w-5 h-5')
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Berita</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Buat berita atau pengumuman baru</p>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="title"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul Berita</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan judul berita...">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="excerpt"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ringkasan</label>
                        <textarea name="excerpt" id="excerpt" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ringkasan singkat berita (opsional)...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="content"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Isi Berita</label>
                        <input type="hidden" name="content" id="content">
                        <div id="editor-container">{!! old('content') !!}</div>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publish Options -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Opsi Publikasi</h3>

                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published') ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Publikasikan langsung</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="is_pinned" value="1"
                                    {{ old('is_pinned') ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Sematkan di atas</span>
                            </label>
                        </div>
                    </div>

                    <!-- Category -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="category_id"
                            class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">Kategori</label>
                        <select name="category_id" id="category_id"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Featured Image -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="featured_image"
                            class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">Gambar Utama</label>
                        <input type="file" name="featured_image" id="featured_image" accept="image/*"
                            class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-400 hover:file:bg-blue-100">
                        @error('featured_image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            @svg('fas-save', 'w-4 h-4 inline mr-2')
                            Simpan Berita
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var quill = new Quill('#editor-container', {
                    theme: 'snow',
                    placeholder: 'Tulis isi berita di sini...',
                    modules: {
                        toolbar: [
                            [{
                                'header': [1, 2, 3, 4, 5, 6, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'align': []
                            }],
                            ['link', 'image', 'video'],
                            ['blockquote', 'code-block'],
                            ['clean']
                        ]
                    }
                });

                // Sync content to hidden input on form submit
                var form = document.querySelector('form');
                form.addEventListener('submit', function() {
                    var contentInput = document.querySelector('#content');
                    contentInput.value = quill.root.innerHTML;
                });
            });
        </script>
    @endpush
</x-layouts.app>
