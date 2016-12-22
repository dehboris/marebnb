@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <div class="container">
            <header class="header">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" width="150px">
                </div>

                <div class="toolbar">
                    <div class="heading">
                        <h1>Administracijsko sučelje</h1>
                    </div>

                    {{-- <div class="actions">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                    </div> --}}
                </div>
            </header>

            <section class="content">
                <aside class="sidebar">
                    <div class="navigation">
                        <h1>Navigacija</h1>

                        <div class="list">
                            <a href="{{ route('home') }}" class="{{ is_route('home') }}">Početno <span class="badge"><i class="fa fa-fw fa-dashboard"></i></span></a>
                            <a href="{{ route('users.index') }}" class="{{ is_route('users.index') }}">Korisnici <span class="badge"><i class="fa fa-fw fa-users"></i></span></a>
                            <a href="{{ route('objects.index') }}" class="{{ is_route('objects.index') }}">Objekti <span class="badge"><i class="fa fa-fw fa-building"></i></span></a>
                            <a href="{{ route('categories.index') }}" class="{{ is_route('categories.index') }}">Kategorije <span class="badge"><i class="fa fa-fw fa-folder"></i></span></a>
                            <a href="{{ route('reservations.index') }}" class="{{ is_route('reservations.index') }}">Rezervacije <span class="badge"><i class="fa fa-fw fa-calendar"></i></span></a>
                            <a href="{{ route('rooms.index') }}" class="{{ is_route('rooms.index') }}">Smještajne jedinice <span class="badge"><i class="fa fa-fw fa-bed"></i></span></a>
                        </div>
                    </div>
                </aside>

                <section class="main">
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

                    @yield('dashboard')
                </section>
            </section>
        </div>
    </div>
@endsection