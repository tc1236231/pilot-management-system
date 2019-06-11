<div class="topNav" onmousemove="onCanvasMouseMove(event)" onmousedown="onCanvasMouseDown(event)">
    <div class="wrapper">
        <div class="userNav">
            <ul>
                <li><a onclick="onMiniModeBtnClicked()"><img src="{{asset('assets/images/client/cfr/goFull.png')}}"/><span>迷你</span></a></li>
                <li><a onclick="onMinimizeBtnClicked()"><img src="{{asset('assets/images/client/cfr/goBack.png')}}" /><span>最小</span></a></li>
                <li><a id="exit" onclick="onExitBtnClicked()"><img src="{{asset('assets/images/client/cfr/deleteFile.png')}}"/><span>退出</span></a></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>