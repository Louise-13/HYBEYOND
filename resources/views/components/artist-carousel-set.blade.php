@props(['artists', 'duplicate' => false])

<div class="artist-carousel__set" @if ($duplicate) aria-hidden="true" @endif>
    @foreach ($artists as $artist)
        <x-artist-card :artist="$artist" />
    @endforeach
</div>