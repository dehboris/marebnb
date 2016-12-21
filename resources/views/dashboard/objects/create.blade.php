@extends('dashboard.layout')

@section('main')
    <div class="col-md-6">
        <form class="form-horizontal" method="POST" action="{{ route('objects.store') }}">
            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('label') ? ' has-error' : '' }}">
                <label for="label" class="col-sm-3 control-label">Oznaka</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="label" placeholder="Oznaka" name="label" required value="{{ old('label') }}">

                    @if ($errors->has('label'))
                        <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">Dodaj objekt</button>
                </div>
            </div>
        </form>
    </div>
@endsection
