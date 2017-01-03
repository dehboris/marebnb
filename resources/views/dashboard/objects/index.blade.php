@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih objekata

            <div class="pull-right">
                <a href="{{ route('objects.create') }}">Dodaj novi objekt</a>
            </div>
        </div>

        <table class="table table-striped">
            <tr>
                <th>Ime</th>
                <th>Broj smještajnih jedinica u objektu</th>
                <th></th>
            </tr>
            @foreach ($objects as $object)
                <tr>
                    <td style="vertical-align: middle;">{{ $object->label }}</td>
                    <td style="vertical-align: middle;">{{ $object->rooms->count() }}</td>
                    <td style="vertical-align: middle;"><a href="{{ route('objects.edit', $object->id) }}" class="btn"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
