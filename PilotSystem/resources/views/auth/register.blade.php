@extends('auth.layout')
@section('title', '注册呼号')

@section('main')
    <div class="container-fluid page-body-wrapper">
        <div class="row">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth register-full-bg">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h2>呼号注册</h2>
                            <div class="font-weight-light">
                                <a href="{{ url('/login') }}" class="auth-link text-black">已有呼号? <span class="font-weight-medium">登录</span></a>
                            </div>
                            <div class="">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (Session::has('status'))
                                    <div class="alert alert-success">
                                        {{ Session::get('status') }}
                                    </div>
                                @endif
                                <div id="alert-ajax" class="alert alert-warning" style="display: none;">
                            </div>
                            <div class="pt-4">
                                {{ Form::open(['url' => url('/register'), 'method' => 'POST']) }}
                                <div class="form-group">
                                    {{ Form::label('platform', '平台选择') }}
                                    <select name="platform" class="form-control">
                                        @foreach($platforms as $platform)
                                            <option value='{{ $platform->code }}'>{{ $platform->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('callsign', '呼号 (4位纯数字 0000)') }}
                                    {{
                                       Form::text('callsign', null, [
                                           'name' => 'callsign',
                                           'class' => 'form-control',
                                           'placeholder' => '',
                                           'required' => true,
                                           'maxlength' => 4,
                                           'inputmode' => 'numeric',
                                           'pattern' => '[0-9]*',
                                       ])
                                    }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('email', '邮箱') }}
                                    {{
                                       Form::email('email', null, [
                                           'name' => 'email',
                                           'class' => 'form-control',
                                           'placeholder' => '',
                                           'required' => true
                                       ])
                                    }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('email_confirmation', '重复邮箱 (接收激活邮件)') }}
                                    {{
                                       Form::email('email_confirmation', null, [
                                           'name' => 'email_confirmation',
                                           'class' => 'form-control',
                                           'placeholder' => '',
                                           'required' => true
                                       ])
                                    }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password', '密码') }}
                                    {{
                                       Form::password('password', [
                                           'name' => 'password',
                                           'class' => 'form-control',
                                           'placeholder' => '',
                                           'required' => true,
                                       ])
                                    }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password_confirmation', '重复密码') }}
                                    {{
                                       Form::password('password_confirmation', [
                                           'name' => 'password_confirmation',
                                           'class' => 'form-control',
                                           'placeholder' => '',
                                           'required' => true,
                                       ])
                                    }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('icqname', '聊天软件 (国内用户请使用QQ号 加群使用)') }}
                                    <select name="icqname" id="icqname" class="form-control w-25">
                                        <option value="QQ号">QQ号</option>
                                    </select>
                                    {{
                                       Form::text('icq', null, [
                                           'name' => 'icq',
                                           'class' => 'form-control w-75',
                                           'placeholder' => '聊天软件号码',
                                           'required' => true
                                       ])
                                    }}
                                </div>

                                <div>
                                    @include('auth.toc')
                                </div>
                                <div class="mt-0 w-75 mx-auto">
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            {{ Form::hidden('toc_accepted', 0, false) }}
                                            {{ Form::checkbox('toc_accepted', 1, null, ['id' => 'toc_accepted', 'class' => 'form-check-input']) }}
                                            我已阅读并同意用户条款须知
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    {{ Form::submit('注册',
                                        ['class' => 'btn btn-block btn-primary btn-lg font-weight-medium', 'id' => 'register_button', 'disabled' => 'true']
                                    ) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
@endsection

@section('script')
<script>
    $('#toc_accepted').click(function () {
      if ($(this).is(':checked')) {
        $('#register_button').removeAttr('disabled');
      } else {
        $('#register_button').attr('disabled', 'true');
      }
    });
    $("form").submit(function (e) {
        if ($(this).attr("attempted") === 'true' ) {
            e.preventDefault();
        }
        else {
            $(this).attr("attempted", 'true');
        }
    });
</script>
@endsection
@section('footer')
@endsection
