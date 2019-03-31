@extends('dashboard.layout')
@section('title')
    日志浏览
@endsection
@section('page-name')
    日志浏览
@endsection
@section('content')
    <div class="row">
        <div class="card col-lg-12 p-3">
            <table class="table table-bordered">
                <tr>
                    <td align="center">ID</td>
                    <td align="center">飞行员呼号</td>
                    <td align="center">权限</td>
                    <td align="center">状态</td>
                    <td align="center">内容</td>
                    <td align="center">日期</td>
                    <td align="center">管理员呼号</td>
                </tr>
                @foreach($logs as $log)
                    <tr>
                        <td align="center">{{ $log->id }}</td>
                        <td align="center">{{ $log->searchid }}</td>
                        <td align="center">{{ $log->level }}</td>
                        <td align="center">{{ $log->namelog }}</td>
                        <td align="center">{{ $log->txt }}</td>
                        <td align="center">{{ $log->time }}</td>
                        <td align="center">{{ $log->admin_callsign }}</td>
                    </tr>
                @endforeach
            </table>
            {{ $logs->links() }}
        </div>
    </div>
@endsection