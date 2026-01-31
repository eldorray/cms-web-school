<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script>
        window.setAppearance = function(appearance) {
            let setDark = () => document.documentElement.classList.add('dark')
            let setLight = () => document.documentElement.classList.remove('dark')
            let setButtons = (appearance) => {
                document.querySelectorAll('button[onclick^="setAppearance"]').forEach((button) => {
                    button.setAttribute('aria-pressed', String(appearance === button.value))
                })
            }
            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')
                window.localStorage.removeItem('appearance')
                media.matches ? setDark() : setLight()
            } else if (appearance === 'dark') {
                window.localStorage.setItem('appearance', 'dark')
                setDark()
            } else if (appearance === 'light') {
                window.localStorage.setItem('appearance', 'light')
                setLight()
            }
            if (document.readyState === 'complete') {
                setButtons(appearance)
            } else {
                document.addEventListener("DOMContentLoaded", () => setButtons(appearance))
            }
        }
        window.setAppearance(window.localStorage.getItem('appearance') || 'system')
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Quill.js Rich Text Editor - 100% Free, No API Key Required --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <style>
        :root {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        body {
            font-family: var(--font-sans);
        }

        .ql-editor {
            min-height: 300px;
            font-family: var(--font-sans);
            font-size: 14px;
        }

        .ql-container {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .ql-toolbar {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background: #f9fafb;
        }

        .dark .ql-toolbar {
            background: #374151;
            border-color: #4b5563;
        }

        .dark .ql-container {
            border-color: #4b5563;
            background: #1f2937;
        }

        .dark .ql-editor {
            color: #f3f4f6;
        }

        .dark .ql-toolbar .ql-stroke {
            stroke: #9ca3af;
        }

        .dark .ql-toolbar .ql-fill {
            fill: #9ca3af;
        }

        .dark .ql-toolbar .ql-picker {
            color: #9ca3af;
        }

        .dark .ql-toolbar button:hover .ql-stroke {
            stroke: #fff;
        }

        .dark .ql-toolbar button:hover .ql-fill {
            fill: #fff;
        }

        .dark .ql-toolbar .ql-picker-label:hover {
            color: #fff;
        }
    </style>
    @stack('scripts')
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased" x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') === null ? window.innerWidth >= 1024 : localStorage.getItem('sidebarOpen') === 'true',
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    },
    temporarilyOpenSidebar() {
        if (!this.sidebarOpen) {
            this.sidebarOpen = true;
            localStorage.setItem('sidebarOpen', true);
        }
    },
    formSubmitted: false,
}">

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col">

        <x-layouts.app.header />

        <!-- Main Content Area -->
        <div class="flex flex-1 overflow-hidden">

            <x-layouts.app.sidebar />

            <!-- Main Content -->
            <main class="flex-1 overflow-auto bg-gray-100 dark:bg-gray-900 content-transition">
                <div class="p-6">
                    <!-- Success Message -->
                    @session('status')
                        <div x-data="{ showStatusMessage: true }" x-show="showStatusMessage"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="mb-6 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 p-4 rounded-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-500 dark:text-green-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 dark:text-green-200">{{ session('status') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button @click="showStatusMessage = false"
                                            class="inline-flex rounded-md p-1.5 text-green-500 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <span class="sr-only">{{ __('Dismiss') }}</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsession

                    {{ $slot }}

                </div>
            </main>
        </div>
    </div>
</body>

</html>
