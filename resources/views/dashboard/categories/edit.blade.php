@extends('dashboard.layout')

@section('main')
    <div class="col-md-6">
        <form class="form-horizontal" method="POST" action="{{ route('categories.update', $category->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="label" class="col-sm-3 control-label">Naziv</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="label" placeholder="Naziv kategorije" name="name" required value="{{ old('name') ?? $category->name }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">Uredi kategoriju</button>
                </div>
            </div>
        </form>
    </div>
@endsection
