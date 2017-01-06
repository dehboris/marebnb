@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih kategorija

            @if (Auth::user()->isOwner())
            <div class="pull-right">
                <a href="{{ route('categories.create') }}">Dodaj novu kategoriju</a>
            </div>
            @endif
        </div>

        <table class="table table-striped">
            <tr>
                <th>Ime</th>
                <th>Broj smještajnih jedinica</th>
                @if (Auth::user()->isOwner())
                <th></th>
                @endif
            </tr>
            @foreach ($categories as $category)
                <tr>
                    <td style="vertical-align: middle;">{{ $category->name }}</td>
                    <td style="vertical-align: middle;">{{ $category->rooms->count() }}</td>
                    @if (Auth::user()->isOwner())
                    <td style="vertical-align: middle;"><a href="{{ route('categories.edit', $category->id) }}" class="btn"><i class="fa fa-edit"></i></a>
                    @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
