@extends('layouts.auth')

@section('title', 'Choose a new password — HYBEYOND')
@section('kicker', 'Account recovery')
@section('heading', 'Set a new password')
@section('description', 'Choose a new password for your HYBEYOND account.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="auth-field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" autocomplete="email" required autofocus>
        </div>
        <div class="auth-field">
            <label for="password">New password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
        </div>
        <div class="auth-field">
            <label for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
        </div>
        <button class="button auth-submit" type="submit">Update password <span aria-hidden="true">↗</span></button>
    </form>
@endsection