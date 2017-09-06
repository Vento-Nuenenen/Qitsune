@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(Auth::check() && Auth::user()->fk_role == 2)
                        <div class="welcome">
                            Hallo {{ ((Auth::user()->scoutname != null) ? Auth::user()->scoutname : Auth::user()->prename) }}. <br/>
                            Dein Login-Name ist <b>{{ ((Auth::user()->scoutname != null) ? Auth::user()->prename."_".Auth::user()->scoutname."_".Auth::user()->surname : Auth::user()->prename."_".Auth::user()->surname) }}</b>.
                            Merk dir diesen, damit du dich später wieder Einloggen kannst.
                        </div>

                        <div class="rules">
                            <h1>Spielregeln</h1>
                            Auf dem Gelände sind QR-Codes versteckt. Finde diese und Scanne sie mit deinem SmartPhone ein.
                            Auf dem Admin-Monitor sieht du die aktuelle Rangliste, nach Anzahl gefundener QR-Codes.
                        </div>

                    @elseif(Auth::check() && Auth::user()->fk_role == 1)
	                    <div class="welcome">
		                    Hallo {{ ((Auth::user()->scoutname != null) ? Auth::user()->scoutname : Auth::user()->prename) }}. <br/>
		                    Dein Login-Name ist <b>{{ ((Auth::user()->scoutname != null) ? Auth::user()->prename."_".Auth::user()->scoutname."_".Auth::user()->surname : Auth::user()->prename."_".Auth::user()->surname) }}</b>.
		                    Merk dir diesen, damit du dich später wieder Einloggen kannst.
	                    </div>
	                    <div class="rank">
		                    <h1>Aktuelle Rangliste:</h1>
		                    <table class="table table-hover table-responsive">
			                    <tr>
				                    <th>
					                    Rang
				                    </th>
				                    <th>
										Vorname
				                    </th>
				                    <th>
					                    Pfadiname
				                    </th>
				                    <th>
					                    Nachname
				                    </th>
				                    <th>
					                    Punkte
				                    </th>
			                    </tr>
								@for($i = 0; $i < $userRank; ++$i)
									<tr>
										<td>{{ $i }}</td>
										<td>{{ $rankArray[$i]['prename'] }}</td>
					                    <td>{{ $rankArray[$i]['scoutname'] }}</td>
					                    <td>{{ $rankArray[$i]['surname'] }}
					                    <td>{{ $rankArray[$i]['rank'] }}</td>
									</tr>
								@endfor
		                    </table>
		                </div>
                    @else
                            <script>window.location.href = "/";</script>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
