@extends('layouts.auth')

@section('title', 'Confirm password — HYBEYOND')
@section('kicker', 'Security check')
@section('heading', 'Confirm password')
@section('description', 'For your security, please confirm your password to continue.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('password.confirm.store') }}">
        @csrf
        <div class="auth-field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
        </div>
        <button class="button auth-submit" type="submit">Confirm <span aria-hidden="true">↗</span></button>
    </form>
@endsection