@extends('dashboard.layout')

@section('dashboard')
    <div class="panel panel-default">
        <div class="panel-heading">
            Pregled svih rezervacija
        </div>

        <table class="table table-striped">
            <tr>
                <th>Smještajna jedinica</th>
                <th>Korisnik</th>
                <th>Datum rezervacije</th>
                <th>Broj ljudi</th>
                <th>Dodatne usluge</th>
                <th>Status rezervacije</th>
                <th></th>
            </tr>
            @foreach ($reservations as $reservation)
                <tr>
                    <td style="vertical-align: middle;"><a href="{{ route('rooms.edit', $reservation->room_id) }}">{{ $reservation->room->label }} &rarr;</a></td>
                    <td style="vertical-align: middle;">{{ $reservation->user->fullName() }}</td>
                    <td style="vertical-align: middle;">{{ $reservation->date_start->format('d/m/Y') }} - {{ $reservation->date_end->format('d/m/Y') }}</td>
                    <td style="vertical-align: middle;"><i class="fa fa-user"></i> {{ $reservation->adults }}&nbsp;&nbsp;&nbsp;<i class="fa fa-child"></i> {{ $reservation->children }}</td>
                    <td style="vertical-align: middle;">
                        @if ($reservation->need_wifi)
                            <i class="fa fa-wifi"></i>
                        @endif

                        @if ($reservation->need_parking)
                            <i class="fa fa-car"></i>
                        @endif

                        @if ($reservation->need_tv)
                            <i class="fa fa-tv"></i>
                        @endif
                    </td>
                <td style="vertical-align: middle;">{!! $reservation->approved_at ? '<span class="label label-success">Prihvaćena</span>' : '<span class="label label-warning">Čeka na obradu</span>' !!}</td>
                    <td style="vertical-align: middle;">
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-xs"><i class="fa fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div>
        {{ $reservations->links() }}
    </div>
@endsection
