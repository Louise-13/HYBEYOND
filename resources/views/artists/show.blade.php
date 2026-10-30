@extends('layouts.public')

@section('title', $artist['name'].' — HYBEYOND')
@section('meta-description', 'Explore the HYBEYOND sample profile for '.$artist['name'].'.')
@section('main-class', 'public-main--page')

@section('content')
    <article class="artist-profile">
        <section class="profile-hero" aria-labelledby="profile-title">
            <img class="profile-hero__image" src="{{ asset('images/artists/'.$artist['image']) }}" alt="{{ $artist['name'] }} artist image">
            <div class="profile-hero__shade" aria-hidden="true"></div>
            <div class="page-wrap profile-hero__content">
                <a class="profile-back" href="{{ route('artists.index') }}">← All artists</a>
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> SAMPLE PROFILE · {{ strtoupper($artist['type']) }}</p>
                <h1 id="profile-title">{{ $artist['name'] }}</h1>
                <p>A profile in progress. Artist details are being prepared for review and verification.</p>
            </div>
        </section>

        <div class="page-wrap profile-content">
            <section class="profile-quick" aria-labelledby="quick-title">
                <h2 id="quick-title">AT A GLANCE</h2>
                <dl>
                    <div><dt>Profile type</dt><dd>{{ $artist['type'] }}</dd></div>
                    <div><dt>Information status</dt><dd>Sample content</dd></div>
                    <div><dt>Editorial note</dt><dd>Details pending verification</dd></div>
                </dl>
            </section>

            <section class="profile-section" aria-labelledby="biography-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> 01 / OVERVIEW</p>
                <h2 id="biography-title">Biography</h2>
                <p class="profile-placeholder">This sample biography section will provide a researched introduction to {{ $artist['name'] }}. Editorial copy will be added after source verification.</p>
            </section>

            <section class="profile-section" aria-labelledby="members-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> 02 / PEOPLE</p>
                <h2 id="members-title">Members</h2>
                <p class="profile-placeholder">Member details and individual profiles will appear here once verified.</p>
            </section>

            <section class="profile-section" aria-labelledby="discography-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> 03 / RELEASES</p>
                <h2 id="discography-title">Discography</h2>
                <p class="profile-placeholder">Release entries are being prepared. No sample release data is presented as fact.</p>
            </section>

            <section class="profile-section" aria-labelledby="timeline-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> 04 / HISTORY</p>
                <h2 id="timeline-title">Career timeline</h2>
                <p class="profile-placeholder">Career milestones will be added with supporting sources.</p>
            </section>

            <section class="profile-section" aria-labelledby="links-title">
                <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> 05 / ELSEWHERE</p>
                <h2 id="links-title">Official links</h2>
                <p class="profile-placeholder">Verified official links will be listed here.</p>
            </section>
        </div>
    </article>
@endsection