@extends('dashboard.layout')

@section('dashboard')
    <div class="col-md-10">
        <form class="form-horizontal" method="POST" action="{{ route('objects.update', $object->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group {{ $errors->has('label') ? ' has-error' : '' }}">
                <label for="label" class="col-sm-3 control-label">Oznaka</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="label" placeholder="Oznaka" name="label" required value="{{ old('label') ?? $object->label }}">

                    @if ($errors->has('label'))
                        <span class="help-block">
                            <strong>{{ $errors->first('label') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary btn-block">Uredi objekt</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-10" style="border-top: 1px solid #eee; margin-top: 10px; padding-top: 30px">
        <form class="form-horizontal" method="POST" action="{{ route('objects.destroy', $object->id) }}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-danger btn-block">Obriši objekt</button>
                </div>
            </div>
        </form>
    </div>
@endsection
