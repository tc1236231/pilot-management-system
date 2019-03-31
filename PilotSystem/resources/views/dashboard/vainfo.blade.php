<div class="row">
    <div class="col-lg-12">
        <div class="card p-3">
            <div class="card-title">
                航空人生绑定信息
            </div>
            <table class="table table-bordered table-dark">
                <tr>
                    <td align="center">登陆编号</td>
                    <td align="center">航空公司</td>
                    <td align="center">呼号</td>
                    <td align="center">注册邮箱</td>
                    <td align="center">总航班数</td>
                    <td align="center">总飞行小时</td>
                    <td align="center">飞行员工资</td>
                    <td align="center">飞行等级</td>
                    <td align="center">充值余额</td>
                </tr>
                @if($va == "notbinded")
                    <tr>
                        <td colspan="9" align="center">未绑定航空人生</td>
                    </tr>
                @elseif($va == "dberror")
                    <tr>
                        <td colspan="9" align="center">数据库错误</td>
                    </tr>
                @else
                    <tr>
                        <td align="center">CFR{{$va->pilotid}}</td>
                        <td align="center">{{$va->code}}</td>
                        <td align="center">{{$va->lastname}}</td>
                        <td align="center">{{$va->email}}</td>
                        <td align="center">{{$va->totalflights}}</td>
                        <td align="center">{{$va->totalhours}}</td>
                        <td align="center">{{$va->totalpay}}</td>
                        <td align="center">{{$va->rank}}</td>
                        <td align="center">{{$va->personaccount}}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
