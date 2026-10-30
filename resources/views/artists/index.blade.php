@extends('layouts.public')

@section('title', 'Explore Artists — HYBEYOND')
@section('meta-description', 'Explore artist profiles, groups, members, and releases on HYBEYOND.')
@section('main-class', 'public-main--page public-main--directory')

@section('content')
    <section class="directory page-wrap" aria-labelledby="directory-title">
        <header class="page-heading">
            <h1 id="directory-title">EXPLORE<br><span>ARTISTS</span></h1>
            <p class="page-heading__description">Explore the artists, groups, and stories shaping the sound of now.</p>
        </header>

        <form class="directory-filters" method="GET" action="{{ route('artists.index') }}" role="search">
            <label class="directory-search">
                <span class="visually-hidden">Search artists</span>
                <input type="search" name="q" value="{{ $search }}" placeholder="Search by artist name" autocomplete="off" aria-label="Search artists">
            </label>
            <label class="directory-type">
                <span class="visually-hidden">Filter by artist type</span>
                <select name="artist_type" onchange="this.form.requestSubmit()">
                    @foreach ($artistTypes as $artistTypeOption => $artistTypeLabel)
                        <option value="{{ $artistTypeOption }}" @selected($artistType === $artistTypeOption)>{{ $artistTypeLabel }}</option>
                    @endforeach
                </select>
            </label>
            <label class="directory-type">
                <span class="visually-hidden">Filter by group type</span>
                <select name="group_type" onchange="this.form.requestSubmit()" @disabled($artistType === 'soloist')>
                    <option value="all" @selected($groupType === 'all')>All Types</option>
                    @foreach ($groupTypes as $groupTypeOption)
                        <option value="{{ $groupTypeOption }}" @selected($groupType === $groupTypeOption)>{{ $groupTypeOption === 'Boy Group' ? 'Boy Groups' : 'Girl Groups' }}</option>
                    @endforeach
                </select>
            </label>
            <label class="directory-type directory-generation">
                <span class="visually-hidden">Filter by generation</span>
                <select name="generation" onchange="this.form.requestSubmit()" @disabled($artistType === 'soloist')>
                    <option value="all" @selected($generation === 'all')>All Generations</option>
                    @foreach ($generations as $generationOption)
                        <option value="{{ $generationOption }}" @selected($generation === $generationOption)>{{ $generationOption }}</option>
                    @endforeach
                </select>
            </label>
            <label class="directory-type directory-status">
                <span class="visually-hidden">Filter by artist status</span>
                <select name="status" onchange="this.form.requestSubmit()">
                    @foreach ($statuses as $statusOption => $statusLabel)
                        <option value="{{ $statusOption }}" @selected($status === $statusOption)>{{ $statusLabel }}</option>
                    @endforeach
                </select>
            </label>
            <label class="directory-type directory-sort">
                <span class="visually-hidden">Sort artists</span>
                <select name="sort" onchange="this.form.requestSubmit()">
                    @foreach ($sortOptions as $sortOption => $sortLabel)
                        <option value="{{ $sortOption }}" @selected($sort === $sortOption)>{{ $sortLabel }}</option>
                    @endforeach
                </select>
            </label>
            <button class="button button--small" type="submit">Search <span aria-hidden="true">↗</span></button>
            @if ($search !== '' || $artistType !== 'all' || $groupType !== 'all' || $generation !== 'all' || $status !== 'active' || $sort !== 'name_asc')
                <a class="directory-clear" href="{{ route('artists.index') }}">Clear filters</a>
            @endif
        </form>

        <div class="directory-results" aria-live="polite">
            <p class="directory-results__count">SHOWING {{ str_pad((string) $artists->count(), 2, '0', STR_PAD_LEFT) }} OF {{ str_pad((string) $totalArtistCount, 2, '0', STR_PAD_LEFT) }} ARTISTS</p>
            @if ($artists->isNotEmpty())
                @php
                    $currentArtists = $artists->where('affiliation_status', 'current');
                    $formerArtists = $artists->where('affiliation_status', 'former');
                @endphp
                @if ($status === 'all')
                    @if ($currentArtists->isNotEmpty())
                        <h2 class="directory-section-title">Current HYBE K-pop Artists</h2>
                        <div class="directory-grid">
                            @foreach ($currentArtists as $artist)
                                <x-artist-card :artist="$artist" show-company variant="directory" />
                            @endforeach
                        </div>
                    @endif
                    @if ($formerArtists->isNotEmpty())
                        <h2 class="directory-section-title">Former Artists Archive</h2>
                        <div class="directory-grid">
                            @foreach ($formerArtists as $artist)
                                <x-artist-card :artist="$artist" show-company variant="directory" />
                            @endforeach
                        </div>
                    @endif
                @else
                    @if ($status === 'former')<h2 class="directory-section-title">Former Artists Archive</h2>@endif
                    <div class="directory-grid">
                        @foreach ($artists as $artist)
                            <x-artist-card :artist="$artist" show-company variant="directory" />
                        @endforeach
                    </div>
                @endif
            @else
                <p class="directory-empty">No artists match those filters. Try another search.</p>
            @endif
        </div>
    </section>
@endsection