<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="dark">
    <meta name="theme-color" content="#1a202c">
    <meta name="supported-color-schemes" content="dark">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>DiBelajar.In</title>
    <link rel="icon" href="{{ asset('logo.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/css/modify.css', 'resources/js/app.js', 'resources/js/modify.js'])


</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            @if (session('success'))
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                    <div class="bg-green-500 text-white font-bold rounded-lg p-4" role="alert">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
                    <div class="bg-red-500 text-white font-bold rounded-lg p-4" role="alert">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            {{ $slot }}
        </main>
    </div>
</body>

</html>
