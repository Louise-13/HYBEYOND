<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::view('/', 'welcome')->name('home');

Route::get('/artists', function (Request $request) {
    $allArtists = collect(config('encyclopedia.artists', []));
    $search = trim((string) $request->query('q', ''));
    $type = (string) $request->query('type', 'all');
    $types = $allArtists->pluck('type')->unique()->sort()->values();

    if ($type !== 'all' && ! $types->contains($type)) {
        $type = 'all';
    }

    $artists = $allArtists->filter(function (array $artist) use ($search, $type): bool {
        $matchesSearch = $search === '' || Str::contains(Str::lower($artist['name']), Str::lower($search));
        $matchesType = $type === 'all' || $artist['type'] === $type;

        return $matchesSearch && $matchesType;
    })->values();

    return view('artists.index', compact('artists', 'search', 'type', 'types'));
})->name('artists.index');

Route::get('/artists/{slug}', function (string $slug) {
    $artist = collect(config('encyclopedia.artists', []))->firstWhere('slug', $slug);

    abort_if($artist === null, 404);

    return view('artists.show', compact('artist'));
})->name('artists.show');

Route::view('/about', 'about')->name('about');
