@props(['artist', 'showType' => false, 'variant' => 'carousel'])

<a class="artist-card artist-card--{{ $variant }}" href="{{ route('artists.show', ['slug' => $artist['slug']]) }}" aria-label="View {{ $artist['name'] }} profile">
    <figure class="artist-carousel__card">
        <div class="artist-carousel__photo">
            <div class="artist-carousel__placeholder" role="img" aria-label="{{ $artist['name'] }} photo not added" aria-hidden="true">
                <span class="artist-carousel__placeholder-label">PHOTO NOT ADDED</span>
                <strong aria-hidden="true">{{ $artist['mark'] }}</strong>
            </div>
            <img src="{{ asset('images/artists/'.$artist['image']) }}" alt="{{ $artist['name'] }} group photo" loading="lazy" decoding="async">
        </div>
        <figcaption>
            @if ($showType)
                <span class="artist-card__type">{{ $artist['type'] }}</span>
            @endif
            <strong>{{ $artist['name'] }}</strong>
        </figcaption>
    </figure>
</a>