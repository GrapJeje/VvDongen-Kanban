<!doctype html>
<html lang="nl">
<head>
    <!-- Meta -->
    <title>{{ config('app.name') }} · @yield('title') </title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}?v={{ time() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}?v={{ time() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}?v={{ time() }}">
    @yield('meta')

    @livewireStyles
    @livewireScripts
</head>
<body>

<!--------------
      Main
---------------->

<div class="container">
    @yield('content')
    @if (isset($slot))
        {{ $slot }}
    @endif
</div>

<!--------------
    scripts
---------------->

@vite(['resources/sass/app.scss'])
@yield('scripts')
</body>
</html>
