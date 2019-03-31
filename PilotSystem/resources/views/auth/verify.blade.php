@extends('auth.layout')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('验证你的注册邮箱') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('一个新的激活邮件已经发送至你的注册邮箱.') }}
                        </div>
                    @endif

                    {{ __('操作之前,请再次确认注册邮箱内是否收到激活邮件.') }}
                    {{ __('如果未收到请') }}, <a
                            href="{{ route('verification.resend') }}">{{ __('点击此来重发激活邮件') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
