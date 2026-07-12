@php
    use Illuminate\Support\Facades\Route;

    // Safely declare helper functions only if they don't already exist
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

<aside class="flex h-screen w-64 flex-col dark:bg-black">
    <!-- Logo / Brand -->
    <div class="flex h-16 items-center justify-center border-b border-gray-700">
        <span class="text-xl font-bold">Ecommerce Admin</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-6">
        <ul class="space-y-1">
            @foreach ($navigation as $item)
                @php
                    $hasChildren    = !empty($item['children']);
                    $isParentActive = $hasChildren && hasActiveChild($item['children']);
                    $currentActive  = isActiveNav($item['active_pattern'] ?? $item['route']);
                    $activeClass    = 'bg-gray-800 text-white';
                    $inactiveClass  = 'text-gray-300 hover:bg-gray-700 hover:text-white';
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
                                class="h-4 w-4 transition-transform"
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
                                        class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $childActive ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}"
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

    <!-- Footer / User area -->
    <div class="border-t border-gray-700 p-4">
        <span class="text-sm text-gray-400">© {{ date('Y') }} Your App</span>
    </div>
</aside>