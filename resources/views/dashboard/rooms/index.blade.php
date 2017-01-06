@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih smještajnih jedinica

            @if (Auth::user()->isOwner())
            <div class="pull-right">
                <a href="{{ route('rooms.create') }}">Dodaj novu smještajnu jedinicu</a>
            </div>
            @endif
        </div>

        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Naziv</th>
                <th>Objekt</th>
                <th>Kategorija</th>
                <th>Cijena</th>
                <th>Broj ljudi</th>
                <th>Pogled</th>
                <th>Trenutni status</th>
                @if (Auth::user()->isOwner())
                <th></th>
                @endif
            </tr>
            @foreach ($rooms as $room)
                <tr>
                    <td style="vertical-align: middle;">
                        @if ($room->photos->count())
                            <img src="{{ asset(Storage::url('rooms/'.$room->id.'/'.$room->photos->first()->filename)) }}" width="80" height="80"
                                 class="img img-circle" alt=""></td>
                    @else
                        <img src="http://placehold.it/80x80" class="img img-circle" alt=""></td>
                    @endif
                    <td style="vertical-align: middle;">{{ $room->label }}</td>
                    <td style="vertical-align: middle;">{{ $room->object->label }}</td>
                    <td style="vertical-align: middle;">{{ $room->category->name }}</td>
                    <td style="vertical-align: middle;"><i class="fa fa-euro"></i> {{ $room->price }}</td>
                    <td style="vertical-align: middle;"><i class="fa fa-user"></i> {{ $room->min_people }} &ndash; <i
                                class="fa fa-user"></i> {{ $room->max_people }}</td>
                    <td style="vertical-align: middle;">
                        @if ($room->seaside)
                            <i class="fa fa-anchor"></i>
                        @else
                            <i class="fa fa-tree"></i>
                        @endif
                    </td>
                    <td style="vertical-align: middle;">
                        @if ($room->isReserved())
                            <span class="label label-success">Rezervirano</span></td>
                        @else
                            <span class="label label-warning">Nije rezervirano</span></td>
                        @endif
                    @if (Auth::user()->isOwner())
                    <td style="vertical-align: middle;">
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn"><i class="fa fa-edit"></i></a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        {{ $rooms->links() }}
    </div>
@endsection