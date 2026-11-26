@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="auth-layout">
        <section class="auth-card">
            <h1>Welcome back</h1>
            <p class="muted">Sign in to manage the training institute.</p>

            @if ($errors->any())
                <div class="notice notice-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password">
                </div>
                <button class="button button-full" type="submit">Login</button>
            </form>

            <p class="auth-switch">New here? <a href="{{ route('register') }}">Create an account</a></p>
        </section>
    </div>
@endsection
