@extends('layouts.public')

@section('title', 'About HYBEYOND')
@section('meta-description', 'Learn about HYBEYOND, an independent digital artist encyclopedia.')
@section('main-class', 'public-main--page')

@section('content')
    <section class="about-page page-wrap" aria-labelledby="about-title">
        <p class="eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> OUR POINT OF VIEW</p>
        <h1 id="about-title">BEYOND<br><span>THE MUSIC.</span></h1>
        <div class="about-page__body">
            <p class="about-page__lead">HYBEYOND is an independent digital artist encyclopedia built to bring artist stories, member profiles, and releases into one considered place.</p>
            <p>We are building a useful, readable index for music fans and curious listeners. Profiles are intended to make it easier to follow the people, creative work, and milestones behind the music, with information added as it is researched and verified.</p>
            <a class="button" href="{{ route('artists.index') }}">Explore Artists <span aria-hidden="true">↗</span></a>
        </div>
    </section>
@endsection