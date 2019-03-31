@extends('dashboard.layout')
@section('title')
    论坛绑定
@endsection
@section('page-name')
    论坛绑定
@endsection
@section('content')
    <div class="row">
        {{ Form::open(['route' => 'frontend.dashboard.bindPlatform', 'method' => 'post', 'class' => 'col-6']) }}
        <div class="form-group">
            {{ Form::label('platform', '绑定平台') }}
            <select name="platform" class="form-control">
                @foreach($platforms as $platform)
                    <option value='{{ $platform->code }}'>{{ $platform->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            {{ Form::label('email', '论坛邮箱或用户名') }}
            {{
                Form::text('email', '', [
                    'id' => 'email',
                    'placeholder' => '',
                    'class' => 'form-control',
                    'required' => true,
                ])
            }}
        </div>
        <div class="form-group">
            {{ Form::label('password', '论坛密码') }}
            {{
               Form::password('password', [
                   'name' => 'password',
                   'class' => 'form-control',
                   'placeholder' => '',
                   'required' => true,
               ])
            }}
        </div>
        {{ Form::submit('绑定', ['class' => "btn btn-success"]) }}
        {{ Form::close() }}
        <div class="col-6">
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
        </div>
    </div>
    <br />
    <div class="row">
        <div class="card w-100">
            <div style="height:250px; overflow:scroll; border:1px solid;">
                <h5 style='text-align:center;font-size:20px;'>已绑定详情</h5>
                @include('dashboard.bind')
            </div>
        </div>
    </div>
    <br />
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.unbind').click(function(e){
                e.preventDefault();
                let button = $(this);
                button.prop('disabled', true);
                let platform_code = $(this).attr('platform');
                let parent_entry = $(this).parent().parent();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('frontend.dashboard.unbindPlatform') }}",
                    method: 'delete',
                    data: {
                        platform: platform_code,
                    },
                    success: function(result){
                        $('#alert-ajax').show();
                        $('#alert-ajax').html(result);
                        parent_entry.remove();
                    },
                    error: function (jqXHR, status, err) {
                        $('#alert-ajax').show();
                        $('#alert-ajax').html('解绑失败: ' + err);
                        button.prop('disabled', false);
                    }});
            });
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
