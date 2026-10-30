@extends('layouts.public')

@section('title', $artist['name'].' — HYBEYOND')
@section('meta-description', 'Explore the HYBEYOND artist profile for '.$artist['name'].'.')
@section('main-class', 'public-main--page')

@section('content')
    <article class="artist-profile">
        <section class="profile-hero" aria-labelledby="profile-title">
            @if (! empty($artist['image']))
                <img class="profile-hero__image" src="{{ asset('images/artists/'.$artist['image']) }}" alt="{{ $artist['name'] }} profile" fetchpriority="high">
            @else
                <div class="profile-hero__placeholder" role="img" aria-label="Profile image unavailable for {{ $artist['name'] }}"><span>{{ $artist['mark'] }}</span></div>
            @endif
            <div class="profile-hero__shade" aria-hidden="true"></div>
            <div class="page-wrap profile-hero__content">
                <a class="profile-back" href="{{ route('artists.index') }}"><span aria-hidden="true">←</span> All artists</a>
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> {{ $artist['company'] }} · {{ strtoupper($artist['type']) }}</p>
                <h1 id="profile-title">{{ $artist['name'] }}</h1>
                @if (! empty($artist['korean_name']))<p class="profile-korean-name">{{ $artist['korean_name'] }}</p>@endif
                <p>{{ $artist['biography'] }}</p>
            </div>
        </section>

        <div class="page-wrap profile-content">
            <section class="profile-quick" aria-labelledby="quick-title">
                <h2 id="quick-title">AT A GLANCE</h2>
                <dl>
                    <div><dt>Profile type</dt><dd>{{ $artist['type'] }}</dd></div>
                    @if ($artist['type'] === 'Group')
                        @if (! empty($artist['group_type']))<div><dt>Group type</dt><dd>{{ $artist['group_type'] }}</dd></div>@endif
                        @if (! empty($artist['generation']))<div><dt>Generation</dt><dd>{{ $artist['generation'] }}</dd></div>@endif
                    @endif
                    <div><dt>First artist debut</dt><dd>{{ ! empty($artist['debut_date']) ? $artist['debut_date'] : 'Unavailable' }}</dd></div>
                    @if (array_key_exists('solo_debut_date', $artist))
                        <div><dt>Solo debut</dt><dd>{{ ! empty($artist['solo_debut_date']) ? $artist['solo_debut_date'] : 'Unavailable' }}</dd></div>
                    @endif
                    <div><dt>HYBE affiliation</dt><dd>{{ $artist['affiliation_status'] === 'current' ? 'Current' : 'Former' }}</dd></div>
                    <div><dt>Activity status</dt><dd>{{ ucfirst($artist['activity_status']) }}</dd></div>
                    <div><dt>Label</dt><dd>{{ $artist['company'] }}</dd></div>
                </dl>
                @if (! empty($artist['debut_note']))<p class="profile-status-note">{{ $artist['debut_note'] }}</p>@endif
                @if (! empty($artist['status_note']))<p class="profile-status-note">{{ $artist['status_note'] }}</p>@endif
            </section>

            @if ($artist['type'] === 'Group' && ! empty($artist['members']))
                <section class="profile-section" aria-labelledby="members-title">
                    <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> PEOPLE</p>
                    <h2 id="members-title">Members</h2>
                    <ul class="profile-member-list">
                        @foreach ($artist['members'] as $member)
                            @php($memberName = is_array($member) ? $member['name'] : $member)
                            <li>
                                @if (is_array($member) && ! empty($member['profile_slug']))
                                    <a href="{{ route('artists.show', ['slug' => $member['profile_slug']]) }}">{{ $memberName }}</a>
                                @else
                                    {{ $memberName }}
                                @endif
                                @if (is_array($member) && ! empty($member['korean_name']))<span>{{ $member['korean_name'] }}</span>@endif
                            </li>
                        @endforeach
                    </ul>
                    @if (! empty($artist['member_note']))<p class="profile-status-note">{{ $artist['member_note'] }}</p>@endif
                </section>
            @endif

            @if ($artist['type'] === 'Group' && ! empty($artist['former_members']))
                <section class="profile-section" aria-labelledby="former-members-title">
                    <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> HISTORY</p>
                    <h2 id="former-members-title">Former members</h2>
                    <ul class="profile-member-list">
                        @foreach ($artist['former_members'] as $member)
                            @php($memberName = is_array($member) ? $member['name'] : $member)
                            <li>
                                @if (is_array($member) && ! empty($member['profile_slug']))
                                    <a href="{{ route('artists.show', ['slug' => $member['profile_slug']]) }}">{{ $memberName }}</a>
                                @else
                                    {{ $memberName }}
                                @endif
                                @if (is_array($member) && ! empty($member['korean_name']))<span>{{ $member['korean_name'] }}</span>@endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            <section class="profile-section" aria-labelledby="discography-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> RELEASES</p>
                <h2 id="discography-title">Discography</h2>
                @if (! empty($artist['discography']))
                    <div class="profile-release-list">
                        @foreach ($artist['discography'] as $release)
                            <article class="profile-release">
                                <span>{{ $release['year'] ?? '' }}</span>
                                <h3>{{ $release['title'] }}</h3>
                                @if (! empty($release['type']))<p>{{ $release['type'] }}</p>@endif
                            </article>
                        @endforeach
                    </div>
                @else
                    <p class="profile-empty">Discography details are not yet available in the verified catalog.</p>
                @endif
            </section>

            <section class="profile-section" aria-labelledby="timeline-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> HISTORY</p>
                <h2 id="timeline-title">Career timeline</h2>
                @if (! empty($artist['timeline']))
                    <ol class="profile-timeline">
                        @foreach ($artist['timeline'] as $milestone)
                            <li><time>{{ $milestone['date'] ?? $milestone['year'] ?? '' }}</time><p>{{ $milestone['title'] }}</p></li>
                        @endforeach
                    </ol>
                @else
                    <p class="profile-empty">Career milestones will be added with supporting sources.</p>
                @endif
            </section>

            <section class="profile-section" aria-labelledby="links-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> ELSEWHERE</p>
                <h2 id="links-title">Official links</h2>
                @if (! empty($artist['official_url']))
                    <a class="profile-official-link" href="{{ $artist['official_url'] }}" target="_blank" rel="noopener noreferrer">
                        <span>Official artist page or social</span><span aria-hidden="true">↗</span>
                    </a>
                @else
                    <p class="profile-empty">An official link will be added when one is available.</p>
                @endif
                @if (! empty($artist['source_url']) && $artist['source_url'] !== $artist['official_url'])
                    <a class="profile-source-link" href="{{ $artist['source_url'] }}" target="_blank" rel="noopener noreferrer">Verification source <span aria-hidden="true">↗</span></a>
                @endif
            </section>
        </div>
    </article>
@endsection