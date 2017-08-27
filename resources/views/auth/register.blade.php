@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('scoutname') ? ' has-error' : '' }}">
                            <label for="scoutname" class="col-md-4 control-label">Pfadiname</label>

                            <div class="col-md-6">
                                <input id="scoutname" type="text" class="form-control" name="scoutname" value="{{ old('scoutname') }}" autofocus>

                                @if ($errors->has('scoutname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('scoutname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('prename') ? ' has-error' : '' }}">
                            <label for="prename" class="col-md-4 control-label">Vorname</label>

                            <div class="col-md-6">
                                <input id="prename" type="prename" class="form-control" name="prename" value="{{ old('prename') }}" required>

                                @if ($errors->has('prename'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prename') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="surname" class="col-md-4 control-label">Nachname</label>

                            <div class="col-md-6">
                                <input id="surname" type="surname" class="form-control" name="surname" value="{{ old('surname') }}" required>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
