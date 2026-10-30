<header class="site-header">
    <div class="page-wrap header-inner">
        <a class="wordmark" href="{{ route('home') }}" aria-label="HYBEYOND home">HYBEYOND<span>®</span></a>
        <div class="header-right">
            <nav class="desktop-nav" aria-label="Main navigation">
                <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
                <a href="{{ route('artists.index') }}" @if (request()->routeIs('artists.*')) aria-current="page" @endif>Artists</a>
                <a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a>
            </nav>
            <div class="header-actions">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-link" type="submit">Sign out</button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a class="text-link" href="{{ route('login') }}">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a class="button button--small" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        </div>
        <details class="mobile-menu">
            <summary aria-label="Open navigation menu"><span></span><span></span></summary>
            <nav class="mobile-menu__panel" aria-label="Mobile navigation">
                <a href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
                <a href="{{ route('artists.index') }}" @if (request()->routeIs('artists.*')) aria-current="page" @endif>Artists</a>
                <a href="{{ route('about') }}" @if (request()->routeIs('about')) aria-current="page" @endif>About</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Sign out</button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a class="mobile-menu__join" href="{{ route('register') }}">Register <span aria-hidden="true">↗</span></a>
                    @endif
                @endauth
            </nav>
        </details>
    </div>
</header>