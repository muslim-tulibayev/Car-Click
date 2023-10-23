<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mypost') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-[100vh] w-[100%] flex flex-col">
    <!-- Navigation Bar -->
    @include('components.layouts.navigation')

    <div class="flex flex-1 overflow-auto">
        <!-- Side Bar -->
        <x-side-bar />

        <!-- Page Content -->
        <main class="h-[100%] flex-1 overflow-auto">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
