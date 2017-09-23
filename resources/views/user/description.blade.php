@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Anleitung</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
