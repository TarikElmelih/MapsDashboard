<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('build/assets/app-VJKgI8NZ.css') }}">
        <script src="{{ asset('build/assets/app-DI6-W-r.js') }}" defer></script>

        <!-- Scripts -->
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')


        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            @include('layouts.sidebar') <!-- Including the sidebar -->
            <div class="flex-1">
                @include('layouts.navigation')
                
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
        
                <!-- Page Content -->
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>
