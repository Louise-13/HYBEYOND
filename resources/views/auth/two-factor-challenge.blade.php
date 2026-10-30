@extends('layouts.auth')

@section('title', 'Security check — HYBEYOND')
@section('kicker', 'Security check')
@section('heading', 'Verify it’s you')
@section('description', 'Enter an authenticator code or one of your recovery codes.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('two-factor.login.store') }}">
        @csrf
        <div class="auth-field">
            <label for="code">Authentication code</label>
            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code">
        </div>
        <div class="auth-field">
            <label for="recovery_code">Recovery code</label>
            <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code">
        </div>
        <button class="button auth-submit" type="submit">Continue <span aria-hidden="true">↗</span></button>
    </form>
@endsection