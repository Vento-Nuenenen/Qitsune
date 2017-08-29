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

                    @elseif(Auth::check() && Auth::user()->fk_role == 1)
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Anzahl QR-Codes welche genertîert werden soll:">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button">Generieren</button>
                                </span>
                            </div>
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
