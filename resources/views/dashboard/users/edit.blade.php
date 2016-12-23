@extends('dashboard.layout')

@section('dashboard')
    <div class="col-md-10">
        <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="ime" class="col-sm-3 control-label">Ime</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="ime" placeholder="Ime" name="first_name" required value="{{ old('first_name') ?? $user->first_name }}">

                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="prezime" class="col-sm-3 control-label">Prezime</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="prezime" placeholder="Prezime" name="last_name" required value="{{ old('last_name') ?? $user->last_name }}">

                    @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required value="{{ old('email')  ?? $user->email}}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('street') ? ' has-error' : '' }}">
                <label for="ulica" class="col-sm-3 control-label">Ulica</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="ulica" placeholder="Ulica" name="street" required value="{{ old('street')  ?? $user->street}}">

                    @if ($errors->has('street'))
                        <span class="help-block">
                            <strong>{{ $errors->first('street') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                <label for="grad" class="col-sm-3 control-label">Grad</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="grad" placeholder="Grad" name="city" required value="{{ old('city') ?? $user->city }}">

                    @if ($errors->has('city'))
                        <span class="help-block">
                            <strong>{{ $errors->first('city') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                <label for="zip" class="col-sm-3 control-label">Poštanski broj</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="zip" placeholder="Poštanski broj" name="zip" required value="{{ old('zip') ?? $user->zip }}">

                    @if ($errors->has('zip'))
                        <span class="help-block">
                            <strong>{{ $errors->first('zip') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                <label for="drzava" class="col-sm-3 control-label">Država</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="drzava" placeholder="Država" name="country" required value="{{ old('country') ?? $user->country }}">

                    @if ($errors->has('country'))
                        <span class="help-block">
                            <strong>{{ $errors->first('country') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                <label for="phone" class="col-sm-3 control-label">Broj telefona</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="phone" placeholder="Broj telefona" name="phone" required value="{{ old('phone') ?? $user->phone }}">

                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary btn-block">Uredi korisnika</button>
                </div>
            </div>
        </form>
    </div>
@endsection
