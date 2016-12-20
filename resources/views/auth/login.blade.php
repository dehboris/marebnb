@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="form">
        <form class="login-form" action="/login" method="post">
            {{csrf_field()}}
            <input type="email" placeholder="e-mail" name="email" id="email" value="{{ old('email') }}"/>
            <input type="password" placeholder="password" name="password" id="password"/>
            <h6 class="h6" id="message">
                @foreach ($errors->all() as $error)
                {{$error}}
                @endforeach
            </h6>
            <div id="login_button">
                <button type="submit">login</button>
            </div>
        </form>
    </div>
</div>

@endsection
