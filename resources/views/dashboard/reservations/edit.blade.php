@extends('dashboard.layout')

@section('dashboard')
    <div class="col-md-10">
        <form class="form-horizontal" method="POST" action="{{ route('reservations.update', $reservation->id) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="form-group {{ $errors->has('room_id') ? ' has-error' : '' }}">
                <label for="pogled" class="col-sm-3 control-label">Smještajna jedinica</label>
                <div class="col-sm-9">
                    <select name="room_id" class="form-control">
                        <option value="">Odaberite...</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}"{{ $room->id == $reservation->room_id ? ' selected' : '' }}>{{ $room->label }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('room_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('room_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('adults') ? ' has-error' : '' }}">
                <label for="pogled" class="col-sm-3 control-label">Broj odraslih</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="number" name="adults" class="form-control" value="{{ old('adults') ?? $reservation->adults }}" required>
                    </div>

                    @if ($errors->has('adults'))
                        <span class="help-block">
                            <strong>{{ $errors->first('adults') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('children') ? ' has-error' : '' }}">
                <label for="pogled" class="col-sm-3 control-label">Broj djece</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-child"></i>
                        </span>
                        <input type="number" name="children" class="form-control" value="{{ old('children') ?? $reservation->children }}" required>
                    </div>

                    @if ($errors->has('children'))
                        <span class="help-block">
                            <strong>{{ $errors->first('children') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('date_start') ? ' has-error' : '' }}">
                <label for="pogled" class="col-sm-3 control-label">Od</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="date" name="date_start" class="form-control" value="{{ old('date_start') ?? $reservation->date_start->format('Y-m-d') }}" required>
                    </div>

                    @if ($errors->has('date_start'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_start') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('date_end') ? ' has-error' : '' }}">
                <label for="pogled" class="col-sm-3 control-label">Do</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="date" name="date_end" class="form-control" value="{{ old('date_end') ?? $reservation->date_end->format('Y-m-d') }}" required>
                    </div>

                    @if ($errors->has('date_end'))
                        <span class="help-block">
                            <strong>{{ $errors->first('date_end') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="pogled" class="col-sm-3 control-label">Dodatne usluge</label>
                <div class="col-sm-9">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="need_tv" value="1"{{ $reservation->need_tv ? ' checked' : '' }}> <i class="fa fa-tv"></i>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="need_wifi" value="1"{{ $reservation->need_wifi ? ' checked' : '' }}> <i class="fa fa-wifi"></i>
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="need_parking" value="1"{{ $reservation->need_parking ? ' checked' : '' }}> <i class="fa fa-car"></i>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary btn-block">Uredi rezervaciju</button>
                </div>
            </div>
        </form>
    </div>

    @if (!$reservation->isApproved())
        <div class="col-md-10" style="border-top: 1px solid #eee; margin-top: 10px;">
            <form action="{{ route('reservations.handle', $reservation->id) }}" method="POST">
                {{ csrf_field() }}


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9" style="padding: 0">
                        <div class="col-md-6" style="padding: 0; padding-right: 5px">
                            <button class="btn btn-success btn-block" type="submit" value="1" name="accepted">
                                <i class="fa fa-check"></i> Prihvati
                            </button>
                        </div>

                        <div class="col-md-6" style="padding: 0; padding-left: 5px">
                            <button class="btn btn-danger btn-block" type="submit" value="0" name="accepted">
                                <i class="fa fa-ban"></i> Odbij
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div class="col-md-10" style="border-top: 1px solid #eee; margin-top: 10px; padding-top: 30px">
        <form class="form-horizontal" method="POST" action="{{ route('reservations.destroy', $reservation->id) }}">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-danger btn-block">Obriši rezervaciju</button>
                </div>
            </div>
        </form>
    </div>
@endsection