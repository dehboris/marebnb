@extends('layouts.app')

@section('content')
    <div class="login">
        <div class="window" id="login">

            <form action="{{ route('login') }}" method="POST">
                <img src="{{ asset('images/logo.png') }}" width="100%" style="margin-bottom: 20px">
                {{ csrf_field() }}

                @if ($errors->count() != 0)
                    <div class="alert alert-danger text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="E-mail adresa" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Lozinka" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-block btn-success" value="Prijavi se">
                </div>
            </form>
        </div>
    </div>
@endsection
