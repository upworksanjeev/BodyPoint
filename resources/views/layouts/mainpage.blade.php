<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(config('bodypoint.no_index'))
    <meta name="robots" content="noindex, nofollow" />
    @endif

    <title>@yield('title', config('app.name', 'Bodypoint'))</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(Config::get('bodypoint.fav')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(Config::get('bodypoint.fav')) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    



</head>

<body class="font-['Avenir'] antialiased pb-14">

    @include('layouts.header')

    <mainpage>
        @include('partials.messages')
        {{ $slot }}
        <div id="fullLoader" style="display: none">
          <div class="loader"></div>
      </div>
    </mainpage>

    @include('layouts.footer')

<script>
	$('#searchinput').keydown(function (e) {
	  if (e.which == 13) {
		$('#formsearch').submit();
		return false;
	  }
	});
	</script>
  @stack('other-scripts')
</body>

</html>
