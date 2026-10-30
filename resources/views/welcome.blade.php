@extends('layouts.public')

@section('title', 'HYBEYOND — Beyond the Music')
@section('meta-description', 'An independent artist encyclopedia. One destination for every story, every member, and every release.')
@section('main-class', 'public-main--home')
@section('body-class', 'public-shell--home')

@section('content')
    <section class="home-hero" aria-labelledby="home-title" style="--home-hero-image: url('{{ asset('images/artists/illit.jpg') }}')">
        <div class="page-wrap home-hero__content">
            <p class="home-hero__eyebrow"><span class="eyebrow__mark" aria-hidden="true"></span> AN INDEPENDENT ARTIST ENCYCLOPEDIA</p>
            <h1 id="home-title">HYBEYOND</h1>
            <p class="home-hero__tagline">Beyond the Music.</p>
            <p class="home-hero__description">An artist encyclopedia. One destination for every story, every member, and every release.</p>
            <a class="button home-hero__cta" href="{{ route('artists.index') }}">Explore Artists <span aria-hidden="true">↗</span></a>
        </div>
    </section>
@endsection