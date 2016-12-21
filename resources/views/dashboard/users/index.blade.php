@extends('dashboard.layout')

@section('main')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih korisnika

            <div class="pull-right">
                <a href="{{ route('users.create') }}">Dodaj novog korisnika</a>
                @if (App\User::numberOfAdmins() < config('site.max_admins'))
                    &ndash; <a href="{{ route('users.create-admin') }}">Dodaj novog administratora</a>
                @endif
            </div>

        </div>

        <table class="table table-striped">
            <tr>
                <th>Ime i prezime</th>
                <th>Email adresa</th>
                <th>Status korisnika</th>
                <th>Adresa</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td style="vertical-align: middle;">{{ $user->fullName() }}</td>
                    <td style="vertical-align: middle;">{{ $user->email }}</td>
                    <td style="vertical-align: middle;">{!! $user->role() !!}</td>
                    <td style="vertical-align: middle;">{{ $user->street }},<br>{{ $user->zip }} {{ $user->city }}<br>{{ $user->country }}</td>
                    <td style="vertical-align: middle;">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('users.destroy', $user->id) }}" style="display: inline" method="POST">
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
        {{ $users->links() }}
    </div>
@endsection
