@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="form">
        @if ($errors->count() != 0)
            <div class="alert alert-danger" id="message">
                {{ $errors->first() }}
            </div>
        @endif

        <form class="login-form" action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}
            <input type="email" placeholder="E-mail adresa" name="email" id="email" value="{{ old('email') }}" required />
            <input type="password" placeholder="Lozinka" name="password" id="password" required />
            <div id="login_button">
                <button type="submit">Prijava</button>
            </div>
        </form>
    </div>
</div>

@endsection
