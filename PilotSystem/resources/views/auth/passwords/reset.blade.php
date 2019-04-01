@extends('auth.layout')
@section('title', __('Reset Password'))

@section('main')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mx-auto text-white my-3">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('auth.resetpassword') }}</div>
                <div class="panel-body p-3">
                    {{ Form::open([
                        'url' => url('/password/reset'),
                        'method' => 'post',
                        'role' => 'form',
                        'class' => 'form-horizontal',
                        ])
                    }}
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{ __('auth.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('callsign') ? ' has-error' : '' }}">
                            <label for="callsign" class="col-md-4 control-label">{{ __('auth.callsign') }}</label>

                            <div class="col-md-6">
                                <input id="callsign" type="callsign" class="form-control" name="callsign" value="{{ old('callsign') }}" required>

                                @if ($errors->has('callsign'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('callsign') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ __('auth.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">{{ __('auth.confirm_password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
								{{ __('auth.resetpassword') }}
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
