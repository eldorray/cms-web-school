@props(['active' => false, 'title' => '', 'icon' => 'fas-list'])

<li x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="
        if (sidebarOpen) {
            open = !open;
        } else {
            temporarilyOpenSidebar();
            open = true;
        }
    " @class([
        'flex items-center w-full px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-200',
        'bg-blue-50/50 text-blue-700 dark:bg-blue-900/10 dark:text-blue-400 font-semibold' => $active,
        'text-gray-600 dark:text-gray-400' => !$active,
    ])
    :class="{ 'justify-center': !sidebarOpen, 'justify-between': sidebarOpen }">
        <div class="flex items-center" :class="{ 'justify-center': !sidebarOpen }">
            @svg($icon, $active ? 'w-5 h-5 text-blue-600 dark:text-blue-400' : 'w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300')
            <span x-show="sidebarOpen" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2"
                x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition-all duration-300"
                x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2"
                class="ml-3 whitespace-nowrap">{{ $title }}</span>
        </div>
        <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform"
            :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Level 2 submenu -->
    <div x-show="open && sidebarOpen" class="mt-1 ml-4 space-y-1">
        {{ $slot }}
    </div>
</li>
