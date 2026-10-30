@extends('layouts.auth')

@section('title', 'Join HYBEYOND')
@section('kicker', 'Find your frequency')
@section('heading', 'Create account')
@section('description', 'Join the community moving music culture forward.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="auth-field">
            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus>
        </div>
        <div class="auth-field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
        </div>
        <div class="auth-field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
        </div>
        <div class="auth-field">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
        </div>
        <button class="button auth-submit" type="submit">Create account <span aria-hidden="true">↗</span></button>
    </form>
    <p class="auth-switch">Already a member? <a href="{{ route('login') }}">Log in</a></p>
@endsection