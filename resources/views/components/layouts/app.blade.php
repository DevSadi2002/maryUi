<!DOCTYPE html>
<html dir="rtl" lang="ar" class="h-full">

{{-- This is the main layout for the application --}}
{{-- It includes the header, sidebar, and main content area --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">


    {{-- haeder include --}}
    @include('components.layouts.header')

    <!-- إشعار عند فقدان الاتصال -->
    <div wire:offline>
        <x-alert title="فصل النت" description="Ho!" icon="o-home" class="alert-warning" />
    </div>

    {{-- MAIN --}}
    <x-main>
        {{-- SideBar --}}
        @include('components.layouts.sidebar')
        {{-- End Side Bar --}}
        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>

</html>
