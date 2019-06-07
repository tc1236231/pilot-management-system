<table width="100%" class="table table-bordered" border="1">
    <tr>
        <td align="center">平台代码</td>
        <td align="center">名称</td>
        <td align="center">UID</td>
        <td align="center">用户名</td>
        <td align="center">注册邮箱</td>
        <td align="center">货币数量</td>
        <td align="center">操作</td>
    </tr>
    @forelse ($user_platforms as $user_platform)
        <tr>
            <td align="center">{{ $user_platform->platform->code }}</td>
            <td align="center">{{ $user_platform->platform->name }}</td>
            <td align="center">{{ $user_platform->bbsuid }}</td>
            <td align="center">{{ $user_platform->username }}</td>
            <td align="center">{{ $user_platform->email }}</td>
            <td align="center">点击查询</td>
            <td align="center">
                <input name="unbind" type="button" class="unbind" value="解绑" platform="{{ $user_platform->platform->code }}" style="color:#993300;font-size:14px;" />
            </td>
        </tr>
    @empty
        <tr><td colspan="7" align="center"><span style="color:red;">未绑定任何论坛</span></td></tr>
    @endforelse
</table>