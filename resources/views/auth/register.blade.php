@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="auth-layout">
        <section class="auth-card">
            <h1>Create account</h1>
            <p class="muted">Register for access to the Training Institute system.</p>

            @if ($errors->any())
                <div class="notice notice-error" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required maxlength="255" autocomplete="name">
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email">
                </div>
                <div class="form-field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password">
                </div>
                <div class="form-field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
                </div>
                <button class="button button-full" type="submit">Register</button>
            </form>

            <p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </section>
    </div>
@endsection
