@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih smještajnih jedinica

            <div class="pull-right">
                <a href="{{ route('rooms.create') }}">Dodaj novu smještajnu jedinicu</a>
            </div>
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
                <th></th>
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
                            <i class="fa fa-sun-o"></i>
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
                    <td style="vertical-align: middle;">
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('rooms.destroy', $room->id) }}" style="display: inline" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        {{ $rooms->links() }}
    </div>
@endsection