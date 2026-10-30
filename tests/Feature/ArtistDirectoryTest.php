<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class ArtistDirectoryTest extends TestCase
{
    public function test_directory_defaults_to_active_artists_sorted_by_name(): void
    {
        $response = $this->get('/artists');

        $response->assertOk()
            ->assertViewHas('artistType', 'all')
            ->assertViewHas('groupType', 'all')
            ->assertViewHas('generation', 'all')
            ->assertViewHas('status', 'active')
            ->assertViewHas('sort', 'name_asc')
            ->assertViewHas('artists', function ($artists): bool {
                $names = $artists->pluck('name')->all();
                $sortedNames = $names;
                usort($sortedNames, fn (string $left, string $right): int => strcmp(Str::lower($left), Str::lower($right)));

                return $names === $sortedNames
                    && $artists->contains(fn (array $artist): bool => $artist['type'] === 'Group')
                    && $artists->contains(fn (array $artist): bool => $artist['type'] === 'Soloist')
                    && $artists->every(fn (array $artist): bool => $artist['affiliation_status'] === 'current' && $artist['activity_status'] === 'active');
            });
    }

    public function test_search_and_all_directory_filters_combine(): void
    {
        $response = $this->get('/artists?q=Tomorrow&artist_type=group&group_type=Boy%20Group&generation=4th%20Generation&status=active&sort=name_asc');

        $response->assertOk()
            ->assertSee('TOMORROW X TOGETHER')
            ->assertDontSee('ENHYPEN')
            ->assertViewHas('artists', fn ($artists): bool => $artists->count() === 1);
    }

    public function test_directory_renders_filters_without_category_navigation(): void
    {
        $this->get('/artists')
            ->assertOk()
            ->assertDontSee('directory-categories')
            ->assertSee('name="q"', false)
            ->assertSee('name="artist_type"', false)
            ->assertSee('name="group_type"', false)
            ->assertSee('name="generation"', false)
            ->assertSee('name="status"', false)
            ->assertSee('name="sort"', false);
    }

    public function test_group_filters_do_not_assign_generations_to_soloists(): void
    {
        $response = $this->get('/artists?artist_type=soloist&group_type=all&generation=3rd%20Generation&status=active');

        $response->assertOk()
            ->assertViewHas('artists', fn ($artists): bool => $artists->isEmpty());
    }

    public function test_artist_type_and_group_filters_work_independently_and_together(): void
    {
        $this->get('/artists?artist_type=group')
            ->assertOk()
            ->assertViewHas('artists', fn ($artists): bool => $artists->count() === 10 && $artists->every(fn (array $artist): bool => $artist['type'] === 'Group'));

        $this->get('/artists?artist_type=soloist')
            ->assertOk()
            ->assertViewHas('artists', fn ($artists): bool => $artists->count() === 12 && $artists->every(fn (array $artist): bool => $artist['type'] === 'Soloist'));

        $this->get('/artists?artist_type=group&group_type=Girl%20Group&generation=4th%20Generation')
            ->assertOk()
            ->assertViewHas('artists', fn ($artists): bool => $artists->count() === 3 && $artists->every(fn (array $artist): bool => $artist['group_type'] === 'Girl Group' && $artist['generation'] === '4th Generation'));
    }

    public function test_inactive_and_all_status_filters_keep_archive_distinctions(): void
    {
        $this->get('/artists?status=inactive')
            ->assertOk()
            ->assertViewHas('artists', fn ($artists): bool => $artists->isNotEmpty() && $artists->every(fn (array $artist): bool => in_array($artist['activity_status'], ['inactive', 'disbanded'], true)));

        $this->get('/artists?status=all')
            ->assertOk()
            ->assertSee('Current HYBE K-pop Artists')
            ->assertSee('Former Artists Archive')
            ->assertViewHas('artists', fn ($artists): bool => $artists->count() === count(config('encyclopedia.artists')));
    }

    public function test_former_artists_are_separate_and_searchable_in_the_archive(): void
    {
        $response = $this->get('/artists?status=former');

        $response->assertOk()
            ->assertSee('Former Artists Archive')
            ->assertSee('GFRIEND')
            ->assertSee('NU’EST')
            ->assertDontSee('TOMORROW X TOGETHER')
            ->assertViewHas('artists', function ($artists): bool {
                $names = $artists->pluck('name')->all();
                $sortedNames = $names;
                usort($sortedNames, fn (string $left, string $right): int => strcmp(Str::lower($left), Str::lower($right)));

                return $names === $sortedNames
                    && $artists->every(fn (array $artist): bool => $artist['affiliation_status'] === 'former');
            });
    }

    public function test_sorting_by_debut_date_places_missing_dates_last(): void
    {
        config(['encyclopedia.artists' => $this->artistsWithUndatedEntry()]);
        $response = $this->get('/artists?sort=debut_desc');

        $response->assertOk()->assertViewHas('artists', function ($artists): bool {
            $dates = $artists->pluck('debut_date')->filter()->values()->all();
            $sortedDates = $dates;
            rsort($sortedDates);

            return $dates === $sortedDates && $artists->last()['debut_date'] === null;
        });
    }

    public function test_reverse_name_and_oldest_debut_sort_modes_are_applied(): void
    {
        $this->get('/artists?sort=name_desc')->assertOk()->assertViewHas('artists', function ($artists): bool {
            $names = $artists->pluck('name')->all();
            $sortedNames = $names;
            usort($sortedNames, fn (string $left, string $right): int => strcmp(Str::lower($right), Str::lower($left)));

            return $names === $sortedNames;
        });

        config(['encyclopedia.artists' => $this->artistsWithUndatedEntry()]);
        $this->get('/artists?sort=debut_asc')->assertOk()->assertViewHas('artists', function ($artists): bool {
            $dates = $artists->pluck('debut_date')->filter()->values()->all();
            $sortedDates = $dates;
            sort($sortedDates);

            return $dates === $sortedDates && $artists->last()['debut_date'] === null;
        });
    }

    public function test_soloists_have_no_group_generation_and_slugs_are_unique(): void
    {
        $artists = config('encyclopedia.artists');
        $slugs = array_column($artists, 'slug');

        $this->assertCount(count($slugs), array_unique($slugs));

        foreach ($artists as $artist) {
            if ($artist['type'] === 'Soloist') {
                $this->assertNull($artist['group_type']);
                $this->assertNull($artist['generation']);
            }
        }
    }

    public function test_every_artist_image_maps_to_an_existing_local_file_in_the_correct_folder(): void
    {
        $catalogImages = [];

        foreach (config('encyclopedia.artists') as $artist) {
            $expectedFolder = $artist['type'] === 'Group' ? 'groups/' : 'soloists/';

            $this->assertStringStartsWith($expectedFolder, $artist['image']);
            $this->assertFileExists(public_path('images/artists/'.$artist['image']));
            $catalogImages[] = $artist['image'];
        }

        $availableImages = collect(['groups', 'soloists'])
            ->flatMap(fn (string $folder): array => array_map(
                fn (string $path): string => $folder.'/'.basename($path),
                glob(public_path('images/artists/'.$folder.'/*')) ?: [],
            ))
            ->all();

        $this->assertCount(count($catalogImages), array_unique($catalogImages));
        $this->assertEqualsCanonicalizing($availableImages, $catalogImages);
    }

    public function test_artist_cards_and_profiles_render_the_local_image_asset(): void
    {
        $this->get('/artists?status=former&artist_type=group')
            ->assertOk()
            ->assertSee(asset('images/artists/groups/2am.jpg'), false);

        $this->get('/artists/bts')
            ->assertOk()
            ->assertSee(asset('images/artists/groups/bts.jpg'), false);

        $this->get('/artists/han-dong-geun')
            ->assertOk()
            ->assertSee(asset('images/artists/soloists/Han Dong Geun.jpg'), false);
    }

    public function test_group_and_solo_profiles_render_and_member_solo_links_resolve(): void
    {
        $this->get('/artists/bts')
            ->assertOk()
            ->assertSee('3rd Generation')
            ->assertSee(route('artists.show', ['slug' => 'rm']));

        $this->get('/artists/enhypen')
            ->assertOk()
            ->assertSee('Former members')
            ->assertSee('HEESEUNG')
            ->assertSee(route('artists.show', ['slug' => 'evan']));

        $this->get('/artists/evan')
            ->assertOk()
            ->assertSee('Soloist')
            ->assertDontSee('Generation');

        $this->get('/artists/nuest')->assertOk()->assertSee('Former');
    }

    public function test_every_catalog_artist_has_a_resolving_profile_route(): void
    {
        foreach (config('encyclopedia.artists') as $artist) {
            $this->get(route('artists.show', ['slug' => $artist['slug']]))->assertOk();
        }
    }

    private function artistsWithUndatedEntry(): array
    {
        $artists = config('encyclopedia.artists');
        $undatedArtist = $artists[0];
        $undatedArtist['name'] = 'UNDATED TEST ARTIST';
        $undatedArtist['slug'] = 'undated-test-artist';
        $undatedArtist['debut_date'] = null;

        $artists[] = $undatedArtist;

        return $artists;
    }
}