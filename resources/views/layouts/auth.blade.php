<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#080808">
    <title>@yield('title', 'HYBEYOND Access')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-shell">
    <main class="auth-layout">
        <aside class="auth-identity">
            <a class="wordmark" href="{{ url('/') }}" aria-label="HYBEYOND home">HYBEYOND<span>®</span></a>
            <div class="auth-identity__message">
                <p class="auth-identity__eyebrow">A new world of sound</p>
                <h2>Make your<br>own way <span>beyond.</span></h2>
            </div>
            <span class="auth-identity__foot">HYBEYOND · ALWAYS IN MOTION</span>
        </aside>
        <section class="auth-content">
            <div class="auth-panel">
                <a class="auth-home-link" href="{{ url('/') }}">← Back to HYBEYOND</a>
                <p class="auth-kicker">@yield('kicker', 'Member access')</p>
                <h1>@yield('heading')</h1>
                <p class="auth-description">@yield('description')</p>
                @if (session('status'))
                    <p class="auth-message" role="status">{{ session('status') }}</p>
                @endif
                @if ($errors->any())
                    <p class="auth-message auth-message--error" role="alert">{{ $errors->first() }}</p>
                @endif
                @yield('form')
            </div>
        </section>
    </main>
</body>
</html>