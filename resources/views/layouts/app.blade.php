<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/fonts/stylesheet.css') }}">
    <style type="text/css">

    body {
           font-family: 'Avenir' !important;
            font-weight: normal  !important;
        }

        input#search {
             border: 0;
        }

        input#search:focus {
            --tw-ring-color: none;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="container mx-auto px-2 xl:px-0">
        @include('layouts.header')

        <main>
        {{ $slot }}
        </main>

        @include('layouts.footer')
 
    </div>
</body>

</html>
