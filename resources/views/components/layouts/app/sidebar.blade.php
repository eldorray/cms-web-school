            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <div class="h-full flex flex-col">
                    <!-- Sidebar Menu -->
                    <nav class="flex-1 overflow-y-auto custom-scrollbar py-4">
                        <ul class="space-y-1 px-2">
                            <!-- Dashboard -->
                            <x-layouts.sidebar-link href="{{ route('admin.dashboard') }}" icon='fas-gauge-high'
                                :active="request()->routeIs('admin.dashboard')">Dashboard</x-layouts.sidebar-link>

                            <!-- Konten -->
                            <x-layouts.sidebar-two-level-link-parent title="Konten" icon="fas-newspaper"
                                :active="request()->routeIs('admin.posts*') || request()->routeIs('admin.categories*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.posts.index') }}" icon='fas-file-lines'
                                    :active="request()->routeIs('admin.posts*')">Berita</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.categories.index') }}" icon='fas-tags'
                                    :active="request()->routeIs('admin.categories*')">Kategori</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.pages.index') }}" icon='fas-file'
                                    :active="request()->routeIs('admin.pages*')">Halaman</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <!-- Akademik -->
                            <x-layouts.sidebar-two-level-link-parent title="Akademik" icon="fas-graduation-cap"
                                :active="request()->routeIs('admin.events*') || request()->routeIs('admin.teachers*') || request()->routeIs('admin.achievements*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.events.index') }}" icon='fas-calendar-days'
                                    :active="request()->routeIs('admin.events*')">Kalender</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.teachers.index') }}" icon='fas-chalkboard-user'
                                    :active="request()->routeIs('admin.teachers*')">Guru & Staff</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.achievements.index') }}" icon='fas-trophy'
                                    :active="request()->routeIs('admin.achievements*')">Prestasi</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <!-- Media -->
                            <x-layouts.sidebar-two-level-link-parent title="Media" icon="fas-images"
                                :active="request()->routeIs('admin.galleries*') || request()->routeIs('admin.downloads*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.galleries.index') }}" icon='fas-image'
                                    :active="request()->routeIs('admin.galleries*')">Galeri</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.downloads.index') }}" icon='fas-download'
                                    :active="request()->routeIs('admin.downloads*')">Download</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <!-- PPDB -->
                            <x-layouts.sidebar-two-level-link-parent title="PPDB" icon="fas-user-plus"
                                :active="request()->routeIs('admin.ppdb*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.ppdb-periods.index') }}" icon='fas-calendar-check'
                                    :active="request()->routeIs('admin.ppdb-periods*')">Periode</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.ppdb-registrations.index') }}" icon='fas-users'
                                    :active="request()->routeIs('admin.ppdb-registrations*')">Pendaftaran</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>

                            <!-- Pesan Masuk -->
                            <x-layouts.sidebar-link href="{{ route('admin.contacts.index') }}" icon='fas-envelope'
                                :active="request()->routeIs('admin.contacts*')">Pesan Masuk</x-layouts.sidebar-link>

                            <!-- Pengaturan -->
                            <x-layouts.sidebar-two-level-link-parent title="Pengaturan" icon="fas-cog"
                                :active="request()->routeIs('admin.settings*') || request()->routeIs('admin.menus*') || request()->routeIs('admin.users*')">
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.settings.index') }}" icon='fas-sliders'
                                    :active="request()->routeIs('admin.settings*')">Umum</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.menus.index') }}" icon='fas-bars'
                                    :active="request()->routeIs('admin.menus*')">Menu</x-layouts.sidebar-two-level-link>
                                <x-layouts.sidebar-two-level-link href="{{ route('admin.users.index') }}" icon='fas-users-gear'
                                    :active="request()->routeIs('admin.users*')">Pengguna</x-layouts.sidebar-two-level-link>
                            </x-layouts.sidebar-two-level-link-parent>
                        </ul>
                    </nav>
                </div>
            </aside>
