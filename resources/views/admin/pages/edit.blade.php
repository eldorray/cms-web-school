<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pages.index') }}" class="p-2 text-gray-500 hover:text-gray-700">@svg('fas-arrow-left', 'w-5 h-5')</a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Halaman</h1>
        </div>

        <form method="POST" action="{{ route('admin.pages.update', $page) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="title"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Judul</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label for="content"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konten</label>
                        <input type="hidden" name="content" id="content">
                        <div id="editor-container">{!! old('content', $page->content) !!}</div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                        <div>
                            <label for="template"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Template</label>
                            <select name="template" id="template"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                @foreach ($templates as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('template', $page->template) == $key ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="flex items-center"><input type="checkbox" name="is_published" value="1"
                                {{ old('is_published', $page->is_published) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded"><span
                                class="ml-3 text-sm text-gray-700 dark:text-gray-300">Publikasikan</span></label>
                        <label class="flex items-center"><input type="checkbox" name="show_in_menu" value="1"
                                {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded"><span
                                class="ml-3 text-sm text-gray-700 dark:text-gray-300">Tampilkan di menu</span></label>
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gambar</label>
                        @if ($page->getFirstMediaUrl('featured_image'))
                            <img src="{{ $page->getFirstMediaUrl('featured_image') }}"
                                class="w-full h-32 object-cover rounded-lg mb-2">
                        @endif
                        <input type="file" name="featured_image" accept="image/*"
                            class="w-full text-sm text-gray-500">
                    </div>
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 space-y-3">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                        <a href="{{ route('admin.pages.index') }}"
                            class="block w-full px-4 py-2 text-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Batal</a>
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
                    placeholder: 'Tulis konten halaman di sini...',
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

                var form = document.querySelector('form');
                form.addEventListener('submit', function() {
                    var contentInput = document.querySelector('#content');
                    contentInput.value = quill.root.innerHTML;
                });
            });
        </script>
    @endpush
</x-layouts.app>
