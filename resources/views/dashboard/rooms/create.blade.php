@extends('dashboard.layout')

@section('dashboard')
    <div class="col-md-10">
        <form class="form-horizontal" method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('photos') ? ' has-error' : '' }}">
                <label for="photos" class="col-sm-3 control-label">Fotografije</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="photos" name="photos[]" required multiple>

                    @if ($errors->has('photos'))
                        <span class="help-block">
                            <strong>{{ $errors->first('photos') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('object_id') ? ' has-error' : '' }}">
                <label for="objekt" class="col-sm-3 control-label">Objekt</label>
                <div class="col-sm-9">
                    <select name="object_id" id="objekt" class="form-control" required>
                        <option value="">Odaberite...</option>
                        @foreach ($objects as $object)
                            <option value="{{ $object->id }}">{{ $object->label }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('object_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('object_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                <label for="kategorija" class="col-sm-3 control-label">Kategorija</label>
                <div class="col-sm-9">
                    <select name="category_id" id="kategorija" class="form-control" required>
                        <option value="">Odaberite...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('category_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

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

            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                <label for="cijena" class="col-sm-3 control-label">Cijena</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-euro"></i></span>
                        <input type="text" class="form-control" id="cijena" placeholder="Cijena" name="price" required value="{{ old('price') }}">
                    </div>

                    @if ($errors->has('price'))
                        <span class="help-block">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label">Broj ljudi</label>
                <div class="col-sm-9">
                    <div class="col-md-6" style="padding: 0;padding-right: 5px">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="number" class="form-control" placeholder="Od" name="min_people" required value="{{ old('price') }}" min="1">
                        </div>
                    </div>

                    <div class="col-md-6" style="padding: 0;padding-left: 5px">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="number" class="form-control" placeholder="Do" name="max_people" required value="{{ old('price') }}" min="1">
                        </div>
                    </div>

                    @if ($errors->has('min_people'))
                        <span class="help-block">
                            <strong>{{ $errors->first('min_people') }}</strong>
                        </span>
                    @endif

                    @if ($errors->has('max_people'))
                        <span class="help-block">
                            <strong>{{ $errors->first('max_people') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('seaside') ? ' has-error' : '' }}">
                <label for="pogled" class="col-sm-3 control-label">Pogled na</label>
                <div class="col-sm-9">
                    <label class="radio-inline">
                        <input type="radio" name="seaside" value="1" required> More
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="seaside" value="0"> Park
                    </label>

                    @if ($errors->has('seaside'))
                        <span class="help-block">
                            <strong>{{ $errors->first('seaside') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary btn-block">Dodaj smještajnu jedinicu</button>
                </div>
            </div>
        </form>
    </div>
@endsection