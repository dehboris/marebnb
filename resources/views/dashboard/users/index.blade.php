@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih korisnika

            @if (Auth::user()->isOwner())
            <div class="pull-right">
                <a href="{{ route('users.create') }}">Dodaj novog korisnika</a>
                @if (App\User::numberOfAdmins() < config('site.max_admins'))
                    &ndash; <a href="{{ route('users.create-admin') }}">Dodaj novog administratora</a>
                @endif
            </div>
            @endif
        </div>

        <table class="table table-striped">
            <tr>
                <th>Ime i prezime</th>
                <th>Email adresa</th>
                <th>Status korisnika</th>
                @if (Auth::user()->isOwner())
                <th></th>
                @endif
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td style="vertical-align: middle;">{{ $user->fullName() }}</td>
                    <td style="vertical-align: middle;">{{ $user->email }}</td>
                    <td style="vertical-align: middle;">{!! $user->role() !!}</td>
                    @if (Auth::user()->isOwner())
                    <td style="vertical-align: middle;">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn"><i class="fa fa-edit"></i></a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        {{ $users->links() }}
    </div>
@endsection
