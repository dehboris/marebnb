@extends('layouts.app')

@section('content')
    <h4>Administracijsko sučelje (<b>{{ Auth::user()->fullName() }}</b>, {{ Auth::user()->isOwner() ? 'vlasnik' : 'administrator' }})</h4>
    <a href="{{ route('home') }}">&larr; Vratite se na početnu</a> &ndash;
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odjavite se</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    <hr>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('main')
@endsection