<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @livewireStyles
        @vite('resources/css/app.css')
    </head>
    <body>
        @if(session('status'))
            <div class="px-8 py-2 m-auto border border-blue-300 bg-blue-200 rounded w-1/2 text-center">{{ session('status') }} </div>
        @endif

        {{ $slot }}
        
        @livewireScripts
    </body>
</html>
