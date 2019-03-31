<table class="table table-bordered">
    <tr>
        <td align="center">编号</td>
        <td align="center">呼号</td>
        <td align="center">数量</td>
        <td align="center">兑换码</td>
        <td align="center">状态</td>
        <td align="center">类型</td>
        <td align="center">次数</td>
        <td align="center">兑换入账</td>
        <td align="center">备注</td>
    </tr>
    @foreach($all_coupons as $coupon)
        <tr>
            <td align="center">{{ $coupon->id }}</td>
            <td align="center">{{ $coupon->callsign  }}</td>
            <td align="center">{{ $coupon->amount }}</td>
            <td align="center">{{ $coupon->privatekey }}</td>
            <td align="center">
                @if($coupon->yesno == 1 && $coupon->amount > 0 )
                    未入
                @elseif($coupon->yesno == 0 && $coupon->amount > 0 )
                    已入
                @elseif($coupon->yesno == 1 && $coupon->amount == 0 )
                    次数
                @endif
            </td>
            <td align="center">
                @if($coupon->leixing == 1)
                    机组
                @else
                    管制
                @endif
            </td>

            <td align="center">{{ $coupon->cishu }}</td>
            <td align="center">
                @if($coupon->keydate == "" && $coupon->amount ==0 )
                    -
                @elseif($coupon->keydate == "" && $coupon->amount > 0 )
                    未兑换
                @else
                    {{ $coupon->keydate }}
                @endif
            </td>
            <td align="center">{{ $coupon->keybeizhu }}</td>
        </tr>
    @endforeach
</table>
{{ $all_coupons->links() }}