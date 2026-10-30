@props(['artist', 'showCompany' => false, 'variant' => 'carousel'])

<a class="artist-card artist-card--{{ $variant }}" href="{{ route('artists.show', ['slug' => $artist['slug']]) }}" aria-label="View {{ $artist['name'] }} profile">
    <figure class="artist-carousel__card">
        <div class="artist-carousel__photo">
            <div class="artist-carousel__placeholder" @if (empty($artist['image'])) role="img" aria-label="Profile image unavailable for {{ $artist['name'] }}" @else aria-hidden="true" @endif>
                @if (empty($artist['image']))<span class="artist-carousel__placeholder-label">PROFILE IMAGE UNAVAILABLE</span>@endif
                <strong aria-hidden="true">{{ $artist['mark'] }}</strong>
            </div>
            @if (! empty($artist['image']))
                <img src="{{ asset('images/artists/'.$artist['image']) }}" alt="{{ $artist['name'] }} profile" loading="lazy" decoding="async">
            @endif
        </div>
        <figcaption>
            @if ($showCompany)
                <span class="artist-card__company">{{ $artist['company'] }}</span>
            @endif
            <strong>{{ $artist['name'] }}</strong>
        </figcaption>
    </figure>
</a>