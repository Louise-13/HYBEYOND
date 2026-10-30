@extends('layouts.auth')

@section('title', 'Log in — HYBEYOND')
@section('kicker', 'Welcome back')
@section('heading', 'Log in')
@section('description', 'Step back into the world of HYBEYOND.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="auth-field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
        </div>
        <div class="auth-field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
        </div>
        <div class="auth-form__meta">
            <label class="auth-check" for="remember"><input id="remember" name="remember" type="checkbox"> Remember me</label>
            @if (Route::has('password.request'))
                <a class="auth-inline-link" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>
        <button class="button auth-submit" type="submit">Log in <span aria-hidden="true">↗</span></button>
    </form>
    @if (Route::has('register'))
        <p class="auth-switch">New to HYBEYOND? <a href="{{ route('register') }}">Create an account</a></p>
    @endif
@endsection