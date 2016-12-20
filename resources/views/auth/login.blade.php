@extends('layouts.app')

@section('content')
<div class="login-page">
    <div class="form">
        <form class="login-form">
            <input type="email" placeholder="e-mail" id="email"/>
            <input type="password" placeholder="password" id="password"/>
            <h6 class="h6" id="message"></h6>
            <div id="login_button">
                <button type="submit">login</button>
            </div>
        </form>
    </div>
</div>
@endsection
