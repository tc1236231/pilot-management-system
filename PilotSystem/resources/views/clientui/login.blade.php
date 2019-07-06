@extends('clientui.base')
@section('title')
    登录
@endsection
@section('body-attr')class="nobg loginPage"@endsection
@section('main')
    <div class="wrap">
        <!-- Top fixed navigation -->
        <div class="topNav" onmousemove="onCanvasMouseMove(event)" onmousedown="onCanvasMouseDown(event)">
            <div class="wrapper" style="margin-right: 0px; margin-left: 350px;">
                <div class="userNav">
                    <ul>
                        <li><a href="{{ url('/') }}" target="_blank"><img src="{{ asset('assets/images/client/icons/topnav/profile.png') }}" /><span>注册 | 查询呼号状态</span></a></li>
                        <li><a href="https://va.hkrscoc.com/" target="_blank"><img src="{{ asset('assets/images/client/icons/topnav/messages.png') }}" /><span>加入航司</span></a></li>
                        <li><a id="exit" onclick="onExitBtnClicked()"><img src="{{ asset('assets/images/client/cfr/deleteFile.png') }}" /><span>退出</span></a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <!-- Main content wrapper -->
        <div class="loginWrapper">
            <div class="widget" style="margin-top:0px;height: 238px;">
                <div type="button" onclick="dlink()" class="loginLogo" style="margin-left:40px;margin-top:-40px; width:266px;height:90px;left:0px;"><img src="{{ asset('assets/images/client/cfr/Logo.png') }}" width="100%"></div>
                <div class="title"><img src="{{ asset('assets/images/client/icons/dark/files.png') }}" class="titleIcon"><h6>登录面板 | Login</h6></div>
                <form action="index.php" id="validate" class="form" style="height: 165px;">
                    <fieldset>
                        <div class="formRow">
                            <label for="platform">接入平台:</label>
                            <div class="loginInput">
                            <select id="platform" name="platform" >
                                @foreach($platforms as $platform)
                                <option value="{{$platform->id}}" code="{{$platform->code}}">{{$platform->name}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <label for="login">飞行员呼号:</label>
                            <div class="loginInput"><input type="text" maxlength="4" name="login" class="validate" id="loginUsername" placeholder="4位呼号"></div>
                            <div class="clear"></div>
                        </div>
                        <div class="formRow">
                            <label for="pass">飞行员密码:</label>
                            <div class="loginInput"><input type="password" maxlength="20" name="password" class="validate" id="loginPassword" placeholder="呼号密码"></div>
                            <div class="clear"></div>
                        </div>
                        <div class="loginControl" style="margin-top:10px; padding-bottom:20px; padding-top:4px;">
                            <div class="rememberMe">
                                <div class="checker" id="uniform-remMe"><span><input type="checkbox" id="remMe" name="remMe" style="opacity: 0;"></span></div>
                                <label for="remMe">记住密码</label>
                            </div>
                            <input id="loginBtn" type="button" value="登录 | Login" class="dredB logMeIn">
                            <div class="clear"></div>
                        </div>
                        <p style="padding-top: 0px;">
                            * 连飞服务器再次更新，请广大飞友，连线飞行测试稳定性。<br />
                            * 新 X-PLANE 连飞插件更新,使用校验按钮自动更新抢先体验。<br /><br />
                            COC版本: {{ $user_agent }} | 本机IP: {{ $user_ip }}<br />
                        </p>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $("#loginBtn").click(function(){
            var huhao_user=$.trim($("#loginUsername").val());
            if(huhao_user==""){
                swal("错误","请填写呼号! Please input call sign!","error");
                return false;
            }
            var huhao_pwd=$("#loginPassword").val();
            if(huhao_pwd==""){
                swal("错误","请填写呼号密码! Please input call sign password!","error");
                return false;
            }
            var huhao_platform=$("#platform").val();
            var huhao_code=$( "#platform option:selected" ).attr('code');
            $.ajax({
                url:"{{ route('clientui.login.action') }}",
                type:"POST",
                data:{callsign:huhao_user,password:huhao_pwd,platform:huhao_platform},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async:true,
                success:function(data){
                    if(data.status === "success"){
                        try{
                            var remember = document.getElementById("remMe").checked;
                            console.log(huhao_user,huhao_pwd,remember,(huhao_platform+":"+huhao_code));
                            MainWindowJSObject.setLoginParam(huhao_user,huhao_pwd,remember,(huhao_platform+":"+huhao_code));
                        } catch (error) {

                        }
                        location.reload();
                    }else{
                        swal('登录失败',data.message,"error");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    swal("登录失败",errorThrown + ' ' + JSON.parse(xhr.responseText).message,"error");
                }
            });
        });
        $("#loginPassword").keyup(function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                $("#loginBtn").click();
            }
        });
    </script>
@endsection