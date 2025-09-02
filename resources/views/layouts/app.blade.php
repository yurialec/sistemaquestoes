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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation') {{-- navbar fixa no topo (assumindo ~4rem) --}}

    <div class="pt-16 flex"> {{-- espaço da navbar + layout em flex --}}
        @include('layouts.sidebar') {{-- aside ocupa w-64, não é fixed --}}

        <main class="flex-1"> {{-- cresce e nunca é sobreposto --}}
            

            {{ $slot }}
        </main>
    </div>
</div>


</html>