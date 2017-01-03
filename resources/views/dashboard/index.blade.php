@extends('dashboard.layout')

@section('dashboard')
    @if (Auth::user()->isOwner())
        <div class="panel panel-default">
            <div class="panel-heading">
                Pregled zauzeća smještajnih jedinica po danima
            </div>

            <table class="table table-striped">
                <tr>
                    <th>Smještajna jedinica</th>
                    <th>Zauzeće u danima</th>
                </tr>
                    @foreach ($zauzece as $el)
                        <tr>
                            <td style="vertical-align: middle;"><a href="{{ route('rooms.edit', $el['soba']->id) }}">{{ $el['soba']->label }} &rarr;</a></td>
                            <td style="vertical-align: middle;">{{ $el['dani'] }}</td>
                        </tr>
                    @endforeach
            </table>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Rang lista država iz kojih gosti dolaze
            </div>

            <table class="table table-striped">
                <tr>
                    <th>Država</th>
                    <th>Broj gostiju</th>
                </tr>
                @foreach ($drzave as $drzava => $brojLjudi)
                    <tr>
                        <td style="vertical-align: middle;">{{ $drzava }}</td>
                        <td style="vertical-align: middle;">{{ $brojLjudi }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Najtraženije usluge
            </div>

            <table class="table table-striped">
                <tr>
                    <th>Usluga</th>
                    <th>Traženo puta</th>
                </tr>
                @foreach ($usluge as $usluga => $brojLjudi)
                    <tr>
                        <td style="vertical-align: middle;">{{ $usluga }}</td>
                        <td style="vertical-align: middle;">{{ $brojLjudi }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="alert alert-info">Dobrodošli u administracijsko sučelje!</div>
    @endif
@endsection