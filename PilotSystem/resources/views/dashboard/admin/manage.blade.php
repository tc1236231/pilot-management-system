@extends('dashboard.layout')
@section('title')
    呼号管理
@endsection
@section('page-name')
    呼号管理
@endsection
@section('content')
    <div class="row">
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
            <div class="alert {{ Session::get('alert-class') }}">
                {{ Session::get('status') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card px-3">
                {{ Form::open(['route' => 'frontend.dashboard.admin.query', 'method' => 'GET', 'class' => 'col-6 my-1 d-flex']) }}
                <div class="form-group my-4 col-lg-6">
                    {{
                        Form::text('callsign', '', [
                            'id' => 'callsign',
                            'placeholder' => '呼号',
                            'class' => 'form-control',
                            'required' => true,
                        ])
                    }}
                </div>
                {{ Form::submit('查询', ['class' => "btn btn-success my-4 h-25"]) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@if(isset($pilot) && $pilot != null)
    <div class="card p-2 my-3">
        <div class="card-title">
            查询呼号: {{ $pilot->callsign }}
        </div>
        <div>
            {{ Form::open(['route' => 'frontend.dashboard.admin.updateProfile', 'method' => 'put', 'class' => '']) }}
            <input name="callsign" type="hidden" value="{{ $pilot->callsign }}" />
            <table class="table table-bordered mb-2">
                <tr>
                    <td width="auto" height="25" align="left"> 所属平台：</td>
                    <td width="auto" height="25" colspan="6" align="left" id="co" >
                        {{ $pilot->co }}
                        @if($getlevel >= PilotLevel::SUPER_ADMIN)
                            <select name='co' id='co'>
                                @foreach($platforms as $platform)
                                    @if($platform->code == $pilot->co)
                                        <option value="{{ $platform->code }}" selected>{{ $platform->name }}</option>
                                    @else
                                        <option value="{{ $platform->code }}">{{ $platform->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left">呼号状态：</td>
                    <td width="auto" height="25" align="left">
                        {{ $pilot->namelog }}
                        <select name="namelog" id="namelog">
                            @foreach(\App\Models\Enums\PilotNameLog::getOptions($pilot) as $label)
                                @if($pilot->namelog == $label)
                                    <option value="{{ $label }}" selected>
                                        {{ $label }}
                                    </option>
                                @else
                                    <option value="{{ $label }}">
                                        {{ $label }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td width="auto" height="25" align="left">飞行员呼号：</td>
                    <td width="auto" height="25" align="left">{{ $pilot->callsign }} | ID： {{ $pilot->id }}</td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left">呼号类型：</td>
                    <td width="auto" height="25" align="left">
                        {{ PilotLevel::label($pilot->level) }}
                        <select name="level" id="hhtype">
                            @foreach(PilotLevel::getOptions($pilot->level) as $val => $label)
                                @if($pilot->level == $val)
                                    <option value="{{ intval($val) }}" selected>
                                        {{ $label }}
                                    </option>
                                @else
                                    <option value="{{ intval($val) }}">
                                        {{ $label }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td width="auto" height="25" align="left" >飞行员密码：</td>
                    <td width="auto" height="25" align="left" id="ajax_huhao_pwd">重置</td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left" >即使通讯：</td>
                    <td width="auto" height="25" align="left" >@if($getlevel>9) {{ $pilot->icq }} @else 因权限不够,隐藏该信息 @endif</td>
                    <td width="auto" height="25" align="left" >呼号注册邮箱：</td>
                    <td width="auto" height="25" align="left" >@if($getlevel>9) {{ $pilot->email }} @else 因权限不够,隐藏该信息 @endif</td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left" >注册日期：</td>
                    <td width="auto" height="25" align="left" >{{ $pilot->registertime }}</td>
                    <td width="auto" height="25" align="left" >登陆日期：</td>
                    <td width="auto" height="25" align="left" >{{ $pilot->logintime }}</td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left" >累计连飞时长：</td>
                    <td width="auto" height="25" align="left" >{{print_flight_time($pilot->onlinetime)}}</td>
                    <td width="auto" height="25" align="left" >累计管制时长：</td>
                    <td width="auto" height="25" align="left" >{{print_flight_time($pilot->atctime)}}</td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left" >连线时间：</td>
                    <td width="auto" height="25" align="left" >{{ $pilot->pologintime }}</td>
                    <td width="auto" height="25" align="left" >断线时间：</td>
                    <td width="auto" height="25" align="left" >{{ $pilot->poendtime }}</td>
                </tr>
                <tr>
                    <td colspan="10" >新增备注:<span style="color:red;">（备注里的内容，可补充添加, 禁修改删除原有内容；封呼号请发布公告（凭证））</span><br>
                        <input type="text" class="form-control" style="width: 800px;" id="hhtype" name="txt" value="" /></td>
                </tr>
                <tr>
                    <td width="auto" height="25" align="left" >连飞资格：</td>
                    <td width="auto" height="25" align="left" >{{ \App\Models\Enums\PilotFlightPermission::label($pilot->via) }}</td>
                    <td width="auto" height="25" align="left" >更新日期:<span style="color:red;">{{ $pilot->uptime }}</span></td>
                    <td width="auto" height="25" align="left" >
                        {{ Form::submit('修改保存', ['class' => "btn btn-success"]) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="10">历史备注:<textarea class="form-control" style="width:90%;" disabled="disabled">{{ $pilot->txt }}</textarea></td>
                </tr>

                <tr>
                    <td colspan="10">因连飞活动需封号前. 请先向机组发通知. 并截警告图和违规图，并发布到论坛违规区！</td>
                </tr>
            </table>
            {{ Form::close() }}


            <div class="card p-2">
                <div class="card-title">
                    论坛绑定情况
                </div>
                @include('dashboard.bind')
            </div>

            @include('dashboard.vainfo')

            <table width="100%" class="gridtable" border="1">
                <tr>
                    <td colspan="10" align="center">个人信息</td>
                </tr>
                <tr>
                    <td align="center">姓名</td>
                    <td align="center">手机</td>
                    <td align="center">地址</td>
                </tr>
                <tr>
                    <td align="center">@if($getlevel>10) {{ $pilot->realname }} @else 因权限不够,隐藏该信息 @endif</td>
                    <td align="center">@if($getlevel>10) {{ $pilot->phone }} @else 因权限不够,隐藏该信息 @endif</td>
                    <td align="center">@if($getlevel>10) {{ $pilot->dizhi }} @else 因权限不够,隐藏该信息 @endif</td>
                </tr>
            </table>
        </div>
    </div>
@endif
@endsection