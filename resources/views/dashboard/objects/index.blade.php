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
                    <td style="vertical-align: middle;"><a href="{{ route('objects.edit', $object->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('objects.destroy', $object->id) }}" style="display: inline" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
