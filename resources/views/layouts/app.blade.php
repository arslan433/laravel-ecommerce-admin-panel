<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>

    <!-- Fonts (Font Awesome CDN or npm install) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link src={{ asset('theme/css/style.css') }} rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gray-100 dark:bg-black dark:text-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex h-full">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            @include('layouts.navigation')

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('assets/theme/js/index.js') }}"></script>


    @yield('footer-scripts')
    @stack('scripts')

</body>

</html>