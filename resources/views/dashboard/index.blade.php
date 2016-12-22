@extends('layouts.app')

@section('content')
    <h4>Administracijsko sučelje (<b>{{ Auth::user()->fullName() }}</b>, {{ Auth::user()->isOwner() ? 'vlasnik' : 'administrator' }})</h4>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odjavite se</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
    <hr>

    <ul class="list-unstyled">
        <li><a href="{{ route('users.index') }}">Korisnici</a></li>
        <li><a href="{{ route('rooms.index') }}">Smještajne jedinice</a></li>
        <li><a href="{{ route('reservations.index') }}">Rezervacije</a></li>
        <li><a href="{{ route('objects.index') }}">Objekti</a></li>
        <li><a href="{{ route('categories.index') }}">Kategorije</a></li>
    </ul>
@endsection