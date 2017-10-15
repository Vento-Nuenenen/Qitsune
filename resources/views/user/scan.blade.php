@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
	    <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        Der Folgende QR-Code wurde gefunden: <b>{{ $checkExists[0]->game_code }}</b><br/>
                        Dieser bringt dir <b>{{$checkExists[0]->points}}</b> Punkt/e ein.<br/>
                        @if(isset($first))
                            Du hast somit {{ ($checkExists[0]->total_points += 1) }} / {{ $maxPoints }} Codes gefunden.
                        @else
                            Du hast somit {{ ($checkExists[0]->total_points) }} / {{ $maxPoints }} Codes gefunden.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
