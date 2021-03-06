@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-lg-12">
                            <div class="alert alert-danger">
                                <strong>ACHTUNG: Alle bestehenden Daten werden gelöscht.</strong>
                            </div>
                            <form class="form-horizontal" method="GET" action="{{ action('GenerateController@index') }}" id="countQR">
                                <div class="input-group">
                                    <input id="countQR" type="number" min="1" class="form-control" name="countQR"  placeholder="Anzahl QR-Codes welche genertîert werden soll:" required autofocus>
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" type="submit">Generieren</button>
                                    </span>
                                </div>
                            </form>
                            <div class="form-group">
                                &nbsp;
                            </div>
                            <div class="download">
                                <button type="button" class="btn btn-block btn-success" onclick="window.location='{{ url("leader/qr/download") }}'">QR-Codes Herunterladen (PDF)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
