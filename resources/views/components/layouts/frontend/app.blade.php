<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? $school->name }}</title>
    <meta name="description" content="{{ $description ?? ($school->tagline ?? 'Website Resmi ' . $school->name) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: {{ $school->theme_primary_color ?? '#3B82F6' }};
            --secondary-color: {{ $school->theme_secondary_color ?? '#6366F1' }};
            --accent-color: {{ $school->theme_accent_color ?? '#F59E0B' }};
        }

        .bg-primary {
            background-color: var(--primary-color);
        }

        .text-primary {
            color: var(--primary-color);
        }

        .border-primary {
            border-color: var(--primary-color);
        }

        .bg-secondary {
            background-color: var(--secondary-color);
        }

        .text-secondary {
            color: var(--secondary-color);
        }

        .bg-accent {
            background-color: var(--accent-color);
        }

        .text-accent {
            color: var(--accent-color);
        }
    </style>
</head>

@php
    $menuPages = \App\Models\Page::where('school_id', $school->id)->published()->inMenu()->ordered()->get();
@endphp

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <!-- Top Bar -->
        <div class="bg-primary text-white text-sm">
            <div class="container mx-auto px-4 py-2 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-4">
                    @if ($school->phone)
                        <span class="flex items-center gap-1">@svg('fas-phone', 'w-3 h-3') {{ $school->phone }}</span>
                    @endif
                    @if ($school->email)
                        <span class="flex items-center gap-1">@svg('fas-envelope', 'w-3 h-3') {{ $school->email }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    @if ($school->social_media['facebook'] ?? false)
                        <a href="{{ $school->social_media['facebook'] }}" target="_blank"
                            class="hover:opacity-80">@svg('fab-facebook', 'w-4 h-4')</a>
                    @endif
                    @if ($school->social_media['instagram'] ?? false)
                        <a href="{{ $school->social_media['instagram'] }}" target="_blank"
                            class="hover:opacity-80">@svg('fab-instagram', 'w-4 h-4')</a>
                    @endif
                    @if ($school->social_media['youtube'] ?? false)
                        <a href="{{ $school->social_media['youtube'] }}" target="_blank"
                            class="hover:opacity-80">@svg('fab-youtube', 'w-4 h-4')</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Nav -->
        <nav class="container mx-auto px-4" x-data="{ open: false, profileOpen: false }">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @if ($school->getFirstMediaUrl('logo'))
                        <img src="{{ $school->getFirstMediaUrl('logo') }}" alt="{{ $school->name }}"
                            class="h-12 w-auto">
                    @endif
                    <div>
                        <h1 class="font-bold text-lg text-primary leading-tight">{{ $school->name }}</h1>
                        @if ($school->tagline)
                            <p class="text-xs text-gray-500">{{ $school->tagline }}</p>
                        @endif
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('home') ? 'text-primary' : '' }}">Beranda</a>

                    {{-- Profil Dropdown --}}
                    @if ($menuPages->count() > 0)
                        <div class="relative" x-data="{ dropdownOpen: false }" @mouseenter="dropdownOpen = true"
                            @mouseleave="dropdownOpen = false">
                            <button
                                class="text-sm font-medium text-gray-700 hover:text-primary flex items-center gap-1 {{ request()->routeIs('pages.*') ? 'text-primary' : '' }}">
                                Profil
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': dropdownOpen }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                                @foreach ($menuPages as $page)
                                    <a href="{{ route('pages.show', $page) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary">
                                        {{ $page->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('posts.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('posts.*') ? 'text-primary' : '' }}">Berita</a>

                    <a href="{{ route('events.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('events.*') ? 'text-primary' : '' }}">Agenda</a>
                    <a href="{{ route('teachers.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('teachers.*') ? 'text-primary' : '' }}">Guru
                        & Staff</a>
                    <a href="{{ route('achievements.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('achievements.*') ? 'text-primary' : '' }}">Prestasi</a>
                    <a href="{{ route('galleries.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('galleries.*') ? 'text-primary' : '' }}">Galeri</a>
                    <a href="{{ route('downloads.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('downloads.*') ? 'text-primary' : '' }}">Download</a>
                    <a href="{{ route('ppdb.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('ppdb.*') ? 'text-primary' : '' }}">PPDB</a>
                    <a href="{{ route('contact.index') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary {{ request()->routeIs('contact.*') ? 'text-primary' : '' }}">Kontak</a>
                </div>

                <button @click="open = !open" class="lg:hidden p-2 text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Nav -->
            <div x-show="open" x-collapse class="lg:hidden pb-4">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-primary">Beranda</a>

                {{-- Mobile Profil Submenu --}}
                @if ($menuPages->count() > 0)
                    <div x-data="{ submenuOpen: false }">
                        <button @click="submenuOpen = !submenuOpen"
                            class="flex items-center justify-between w-full py-2 text-gray-700 hover:text-primary">
                            <span>Profil</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': submenuOpen }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="submenuOpen" x-collapse class="pl-4 border-l-2 border-gray-200 ml-2">
                            @foreach ($menuPages as $page)
                                <a href="{{ route('pages.show', $page) }}"
                                    class="block py-2 text-gray-600 hover:text-primary">{{ $page->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <a href="{{ route('posts.index') }}" class="block py-2 text-gray-700 hover:text-primary">Berita</a>
                <a href="{{ route('events.index') }}" class="block py-2 text-gray-700 hover:text-primary">Agenda</a>
                <a href="{{ route('teachers.index') }}" class="block py-2 text-gray-700 hover:text-primary">Guru &
                    Staff</a>
                <a href="{{ route('achievements.index') }}"
                    class="block py-2 text-gray-700 hover:text-primary">Prestasi</a>
                <a href="{{ route('galleries.index') }}"
                    class="block py-2 text-gray-700 hover:text-primary">Galeri</a>
                <a href="{{ route('downloads.index') }}"
                    class="block py-2 text-gray-700 hover:text-primary">Download</a>
                <a href="{{ route('ppdb.index') }}" class="block py-2 text-gray-700 hover:text-primary">PPDB</a>
                <a href="{{ route('contact.index') }}" class="block py-2 text-gray-700 hover:text-primary">Kontak</a>
            </div>
        </nav>
    </header>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 container mx-auto px-4 mt-4"
            role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 container mx-auto px-4 mt-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        @if ($school->getFirstMediaUrl('logo'))
                            <img src="{{ $school->getFirstMediaUrl('logo') }}" alt="{{ $school->name }}"
                                class="h-12 w-auto bg-white rounded p-1">
                        @endif
                        <h3 class="font-bold text-lg">{{ $school->name }}</h3>
                    </div>
                    @if ($school->address)
                        <p class="text-gray-400 text-sm">{{ $school->address }}</p>
                    @endif
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Tautan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('posts.index') }}" class="hover:text-white">Berita</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-white">Agenda</a></li>
                        <li><a href="{{ route('galleries.index') }}" class="hover:text-white">Galeri</a></li>
                        <li><a href="{{ route('ppdb.index') }}" class="hover:text-white">PPDB</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @if ($school->phone)
                            <li class="flex items-center gap-2">@svg('fas-phone', 'w-4 h-4') {{ $school->phone }}</li>
                        @endif
                        @if ($school->email)
                            <li class="flex items-center gap-2">@svg('fas-envelope', 'w-4 h-4') {{ $school->email }}</li>
                        @endif
                        @if ($school->website)
                            <li class="flex items-center gap-2">@svg('fas-globe', 'w-4 h-4') {{ $school->website }}</li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        @if ($school->social_media['facebook'] ?? false)
                            <a href="{{ $school->social_media['facebook'] }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition-colors">@svg('fab-facebook', 'w-5 h-5')</a>
                        @endif
                        @if ($school->social_media['instagram'] ?? false)
                            <a href="{{ $school->social_media['instagram'] }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition-colors">@svg('fab-instagram', 'w-5 h-5')</a>
                        @endif
                        @if ($school->social_media['youtube'] ?? false)
                            <a href="{{ $school->social_media['youtube'] }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition-colors">@svg('fab-youtube', 'w-5 h-5')</a>
                        @endif
                        @if ($school->social_media['twitter'] ?? false)
                            <a href="{{ $school->social_media['twitter'] }}" target="_blank"
                                class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-primary transition-colors">@svg('fab-x-twitter', 'w-5 h-5')</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700">
            <div class="container mx-auto px-4 py-4 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ $school->name }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>
