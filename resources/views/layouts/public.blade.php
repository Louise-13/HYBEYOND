<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#080808">
    <meta name="description" content="@yield('meta-description', 'HYBEYOND — Beyond the Music. An independent digital artist encyclopedia.')">
    <title>@yield('title', 'HYBEYOND — Beyond the Music')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="public-shell">
    <a class="skip-link" href="#main">Skip to content</a>
    <x-site-header />
    <main class="public-main @yield('main-class')" id="main">
        @yield('content')
    </main>
    <x-site-footer />
</body>
</html>