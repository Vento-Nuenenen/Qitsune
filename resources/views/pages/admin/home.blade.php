@extends('layouts.app')

@section('template_title')
    Wilkommen {{ Auth::user()->name_gen }}
@endsection

@section('head')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('panels.welcome-panel')

            </div>
        </div>
    </div>

@endsection