@extends('auth.layout')
@section('title', __('auth.login'))

@section('main')
<div class="row">
    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-full-bg">
        <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-dark text-left p-5">
                    <h2>@lang('auth.login')</h2>
                    <h4 class="font-weight-light">全面启用 HTTPS、SSL 通信协议,更好的为飞行员服务</h4>
                    {{ Form::open(['url' => url('/login'), 'method' => 'post']) }}
                        <div class="form-group">
                            <label>{{ __('auth.callsign') }} 0000</label>
                            {{
                                Form::text('callsign', old('callsign'), [
                                    'id' => 'callsign',
                                    'type' => 'number',
                                    'placeholder' => __('auth.callsign'),
                                    'class' => 'form-control',
                                    'required' => true,
                                    'maxlength' => 4,
                                    'inputmode' => 'numeric',
                                    'pattern' => '[0-9]*',
                                ])
                            }}
                        </div>
                        @if ($errors->has('callsign'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('callsign') }}</strong>
                            </span>
                        @endif

                        <div class="form-group">
                            <label>{{ __('auth.password') }}</label>
                            {{
                               Form::password('password', [
                                   'name' => 'password',
                                   'class' => 'form-control',
                                   'placeholder' => __('auth.password'),
                                   'required' => true,
                               ])
                            }}
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                        <div class="mt-4">
                            <button class="btn btn-block btn-warning btn-lg font-weight-medium">@lang('auth.login')</button>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ url('/register') }}" class="btn btn-outline-primary auth-link text-white mx-1">@lang('auth.createaccount')</a>
                            <a href="{{ url('/password/reset') }}" class="btn btn-outline-secondary auth-link text-white mx-1">@lang('auth.forgotpassword')</a>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- row ends -->
@endsection
