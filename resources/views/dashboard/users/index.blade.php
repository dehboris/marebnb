@extends('dashboard.layout')

@section('main')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih korisnika

            @if (App\User::numberOfAdmins() < 3)
            <div class="pull-right">
                <a href="{{ route('users.create-admin') }}">Dodaj novog administratora</a>
            </div>
            @endif
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
                    <td style="vertical-align: middle;"><a href="#"><i class="fa fa-edit"></i></a> &ndash; <a href="#"><i class="fa fa-trash"></i></a></td>
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        {{ $users->links() }}
    </div>
@endsection
