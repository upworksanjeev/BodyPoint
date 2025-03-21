<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(config('bodypoint.no_index'))
    <meta name="robots" content="noindex, nofollow" />
    @endif

    <title>@yield('title', config('app.name', 'Bodypoint'))</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
	 <script src="https://kit.fontawesome.com/731f6c33b2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(Config::get('bodypoint.logo')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(Config::get('bodypoint.logo')) }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-['Avenir'] antialiased">

        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
    <div class="container mx-auto px-2 xl:px-0 border-red-600">
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @include('layouts.footer')
    </div>
</body>
</html>
