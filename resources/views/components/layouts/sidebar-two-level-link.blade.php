@props(['active' => false, 'href' => '#', 'icon' => 'fas-house'])

<a href="{{ $href }}" @class([
    'flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200',
    'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-semibold' => $active,
    'hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 text-gray-600 dark:text-gray-400' => !$active,
])
:class="{ 'justify-center': !sidebarOpen, 'justify-start': sidebarOpen }">
    @svg($icon, $active ? 'w-5 h-5 text-white dark:text-gray-800' : 'w-5 h-5 text-gray-500')
    <span x-show="sidebarOpen" x-transition:enter="transition-all duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2"
        x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition-all duration-300"
        x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2"
        class="ml-3 whitespace-nowrap">{{ $slot }}</span>
</a>
