@extends('layouts.auth')

@section('title', 'Reset password — HYBEYOND')
@section('kicker', 'Account recovery')
@section('heading', 'Forgot password?')
@section('description', 'Enter your email and we’ll send a password reset link.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="auth-field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
        </div>
        <button class="button auth-submit" type="submit">Send reset link <span aria-hidden="true">↗</span></button>
    </form>
    <p class="auth-switch"><a href="{{ route('login') }}">Back to log in</a></p>
@endsection