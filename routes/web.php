<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::view('/', 'welcome')->name('home');

Route::get('/artists', function (Request $request) {
    $allArtists = collect(config('encyclopedia.artists', []));
    $search = trim((string) $request->query('q', ''));
    $artistType = (string) $request->query('artist_type', 'all');
    $groupTypes = config('encyclopedia.group_types', []);
    $generations = config('encyclopedia.generations', []);
    $groupType = (string) $request->query('group_type', 'all');
    $generation = (string) $request->query('generation', 'all');
    $statuses = config('encyclopedia.statuses', []);
    $status = (string) $request->query('status', config('encyclopedia.default_status', 'active'));
    $sortOptions = config('encyclopedia.sort_options', []);
    $sort = (string) $request->query('sort', config('encyclopedia.default_sort', 'name_asc'));

    if (! array_key_exists($artistType, config('encyclopedia.artist_types', []))) {
        $artistType = 'all';
    }
    if ($groupType !== 'all' && ! in_array($groupType, $groupTypes, true)) {
        $groupType = 'all';
    }
    if ($generation !== 'all' && ! in_array($generation, $generations, true)) {
        $generation = 'all';
    }
    if (! array_key_exists($status, $statuses)) {
        $status = config('encyclopedia.default_status', 'active');
    }
    if (! array_key_exists($sort, $sortOptions)) {
        $sort = config('encyclopedia.default_sort', 'name_asc');
    }

    $artists = $allArtists->filter(function (array $artist) use ($search, $artistType, $groupType, $generation, $status): bool {
        $searchable = implode(' ', array_filter([
            $artist['name'],
            $artist['korean_name'] ?? null,
            $artist['company'] ?? null,
        ]));
        $matchesSearch = $search === '' || Str::contains(Str::lower($searchable), Str::lower($search));
        $matchesArtistType = $artistType === 'all'
            || ($artistType === 'group' && $artist['type'] === 'Group')
            || ($artistType === 'soloist' && $artist['type'] === 'Soloist');
        $matchesGroupType = $groupType === 'all'
            || ($artist['type'] === 'Group' && ($artist['group_type'] ?? null) === $groupType);
        $matchesGeneration = $generation === 'all'
            || ($artist['type'] === 'Group' && ($artist['generation'] ?? null) === $generation);
        $matchesStatus = match ($status) {
            'active' => $artist['affiliation_status'] === 'current' && $artist['activity_status'] === 'active',
            'inactive' => in_array($artist['activity_status'], ['inactive', 'disbanded'], true),
            'former' => $artist['affiliation_status'] === 'former',
            default => true,
        };

        return $matchesSearch && $matchesArtistType && $matchesGroupType && $matchesGeneration && $matchesStatus;
    })->all();

    usort($artists, function (array $left, array $right) use ($sort): int {
        $sortDirection = str_ends_with($sort, '_desc') ? -1 : 1;

        if (str_starts_with($sort, 'debut_')) {
            $leftDate = $left['debut_date'] ?? null;
            $rightDate = $right['debut_date'] ?? null;

            if ($leftDate === null || $rightDate === null) {
                return $leftDate === $rightDate ? 0 : ($leftDate === null ? 1 : -1);
            } else {
                $dateComparison = strcmp($leftDate, $rightDate);
            }

            if ($dateComparison !== 0) {
                return $dateComparison * $sortDirection;
            }
        }

        $nameComparison = strcmp(Str::lower($left['name']), Str::lower($right['name']));
        if ($sort === 'name_desc') {
            $nameComparison *= -1;
        }

        return $nameComparison !== 0 ? $nameComparison : strcmp($left['slug'], $right['slug']);
    });

    return view('artists.index', [
        'artists' => collect($artists),
        'totalArtistCount' => $allArtists->count(),
        'search' => $search,
        'artistType' => $artistType,
        'artistTypes' => config('encyclopedia.artist_types', []),
        'groupType' => $groupType,
        'groupTypes' => $groupTypes,
        'generation' => $generation,
        'generations' => $generations,
        'status' => $status,
        'statuses' => $statuses,
        'sort' => $sort,
        'sortOptions' => $sortOptions,
    ]);
})->name('artists.index');

Route::get('/artists/{slug}', function (string $slug) {
    $artist = collect(config('encyclopedia.artists', []))->firstWhere('slug', $slug);

    abort_if($artist === null, 404);

    return view('artists.show', compact('artist'));
})->name('artists.show');

Route::view('/about', 'about')->name('about');
