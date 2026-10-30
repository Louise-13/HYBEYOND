@extends('layouts.public')

@section('title', 'Explore Artists — HYBEYOND')
@section('meta-description', 'Explore artist profiles, groups, members, and releases on HYBEYOND.')
@section('main-class', 'public-main--page')

@section('content')
    <section class="directory page-wrap" aria-labelledby="directory-title">
        <header class="page-heading">
            <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> THE HYBEYOND INDEX</p>
            <h1 id="directory-title">EXPLORE<br><span>ARTISTS</span></h1>
            <p class="page-heading__description">A growing index of artists, their stories, and the work that connects them.</p>
        </header>

        <form class="directory-filters" method="GET" action="{{ route('artists.index') }}" role="search">
            <label class="directory-search">
                <span class="visually-hidden">Search artists</span>
                <input type="search" name="q" value="{{ $search }}" placeholder="Search artists" autocomplete="off">
            </label>
            <label class="directory-type">
                <span class="visually-hidden">Filter by artist type</span>
                <select name="type" onchange="this.form.requestSubmit()">
                    <option value="all" @selected($type === 'all')>All types</option>
                    @foreach ($types as $artistType)
                        <option value="{{ $artistType }}" @selected($type === $artistType)>{{ $artistType }}</option>
                    @endforeach
                </select>
            </label>
            <button class="button button--small" type="submit">Search <span aria-hidden="true">↗</span></button>
            @if ($search !== '' || $type !== 'all')
                <a class="directory-clear" href="{{ route('artists.index') }}">Clear filters</a>
            @endif
        </form>

        <div class="directory-results" aria-live="polite">
            <p class="directory-results__count">{{ $artists->count() }} {{ \Illuminate\Support\Str::plural('ARTIST', $artists->count()) }}</p>
            @if ($artists->isNotEmpty())
                <div class="directory-grid">
                    @foreach ($artists as $artist)
                        <x-artist-card :artist="$artist" show-type variant="directory" />
                    @endforeach
                </div>
            @else
                <p class="directory-empty">No artists match those filters. Try another search.</p>
            @endif
        </div>
    </section>
@endsection