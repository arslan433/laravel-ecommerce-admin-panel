@php
    use Illuminate\Support\Facades\Route;

    if (!function_exists('isActiveNav')) {
        function isActiveNav($patterns) {
            $patterns = (array) $patterns;
            foreach ($patterns as $pattern) {
                if (request()->routeIs($pattern)) {
                    return true;
                }
            }
            return false;
        }
    }

    if (!function_exists('hasActiveChild')) {
        function hasActiveChild($children) {
            foreach ($children as $child) {
                if (isActiveNav($child['active_pattern'] ?? $child['route'])) {
                    return true;
                }
            }
            return false;
        }
    }

    $navigation = config('navigation.items', []);
@endphp

<div 
    x-show="sidebarOpen" 
    class="fixed inset-0 z-40 bg-black/50 transition-opacity lg:hidden"
    @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
></div>

<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex h-screen w-64 flex-col bg-white dark:bg-black border-r border-gray-200 dark:border-gray-800 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:leave="transition ease-in-out duration-300 transform"
>
    <div class="flex h-16 items-center justify-between px-6 border-b border-gray-200 dark:border-gray-800">
        <span class="text-xl font-bold text-gray-800 dark:text-white">LOGO</span>
        
        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white lg:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-6 custom-scrollbar">
        <ul class="space-y-1">
            @foreach ($navigation as $item)
                @php
                    $hasChildren    = !empty($item['children']);
                    $isParentActive = $hasChildren && hasActiveChild($item['children']);
                    $currentActive  = isActiveNav($item['active_pattern'] ?? $item['route']);
                    $activeClass    = 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white';
                    $inactiveClass  = 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-900 hover:text-gray-900 dark:hover:text-white';
                    $linkClass      = ($currentActive || $isParentActive) ? $activeClass : $inactiveClass;
                @endphp

                <li x-data="{ open: {{ $isParentActive ? 'true' : 'false' }} }">
                    @if ($hasChildren)
                        {{-- Parent with children --}}
                        <button
                            @click="open = !open"
                            class="flex w-full items-center rounded-lg px-3 py-2 text-left text-sm font-medium transition-colors {{ $linkClass }}"
                        >
                            @if (!empty($item['icon']))
                                <i class="{{ $item['icon'] }} fa-fw mr-3"></i>
                            @endif
                            <span class="flex-1">{{ $item['label'] }}</span>
                            <svg
                                class="h-4 w-4 transition-transform duration-200"
                                :class="{ 'rotate-90': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        {{-- Children --}}
                        <ul
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="mt-1 space-y-1 pl-8"
                        >
                            @foreach ($item['children'] as $child)
                                @php
                                    $childActive = isActiveNav($child['active_pattern'] ?? $child['route']);
                                @endphp
                                <li>
                                    <a
                                        href="{{ $child['route'] ? route($child['route']) : '#' }}"
                                        class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $childActive ? 'bg-gray-100 text-gray-900 dark:bg-gray-800 dark:text-white' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-900 hover:text-gray-900 dark:hover:text-white' }}"
                                    >
                                        {{ $child['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        {{-- Single item --}}
                        <a
                            href="{{ $item['route'] ? route($item['route']) : '#' }}"
                            class="flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $linkClass }}"
                        >
                            @if (!empty($item['icon']))
                                <i class="{{ $item['icon'] }} fa-fw mr-3"></i>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
</aside>

<style>
    /* Custom Scrollbar styling for Webkit engines */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4b5563; /* Tailwind gray-600 */
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #374151; /* Tailwind gray-700 */
    }
</style>