@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih kategorija

            <div class="pull-right">
                <a href="{{ route('categories.create') }}">Dodaj novu kategoriju</a>
            </div>
        </div>

        <table class="table table-striped">
            <tr>
                <th>Ime</th>
                <th>Broj smještajnih jedinica</th>
                <th></th>
            </tr>
            @foreach ($categories as $category)
                <tr>
                    <td style="vertical-align: middle;">{{ $category->name }}</td>
                    <td style="vertical-align: middle;">{{ $category->rooms->count() }}</td>
                    <td style="vertical-align: middle;"><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('categories.destroy', $category->id) }}" style="display: inline" method="POST">
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
