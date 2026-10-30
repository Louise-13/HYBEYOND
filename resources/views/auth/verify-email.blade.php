@extends('layouts.auth')

@section('title', 'Verify email — HYBEYOND')
@section('kicker', 'One last step')
@section('heading', 'Verify your email')
@section('description', 'Check your inbox for a verification link. You can request another below.')

@section('form')
    <form class="auth-form" method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="button auth-submit" type="submit">Resend verification email <span aria-hidden="true">↗</span></button>
    </form>
@endsection