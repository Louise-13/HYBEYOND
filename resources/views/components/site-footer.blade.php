<footer class="public-footer">
    <div class="page-wrap public-footer__inner">
        <a class="wordmark wordmark--footer" href="{{ route('home') }}" aria-label="HYBEYOND home">HYBEYOND<span>®</span></a>
        <p class="public-footer__motto">Beyond the music.<br><span>An independent artist encyclopedia.</span></p>
        <nav class="public-footer__nav" aria-label="Footer navigation">
            <a href="{{ route('artists.index') }}">Artists</a>
            <a href="{{ route('about') }}">About</a>
        </nav>
        <span class="public-footer__copyright">© {{ now()->year }} HYBEYOND</span>
    </div>
</footer>