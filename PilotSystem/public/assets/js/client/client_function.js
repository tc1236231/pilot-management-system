(async () =>
{
	if(typeof MainWindowJSObject === "undefined")
	{
		await CefSharp.BindObjectAsync("MainWindowJSObject");
	}
})();

function $$(id) {
	return document.getElementById(id);
}
		
function onCanvasMouseMove(e) {
	if(e.buttons == 1)
	{
	    var x = e.clientX;
		var y = e.clientY;
		MainWindowJSObject.onNavMouseMove(x, y);	
	}
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function onCanvasMouseDown(e) {
    var x = e.clientX;
    var y = e.clientY;
	MainWindowJSObject.onNavMouseDown(x, y);
}

function onConnectBtnClicked(isVIP) {
	var e = document.getElementById("selectServer");
	var strUser = e.options[e.selectedIndex].value;
	if(isEmpty(strUser))
	{
		swal("提示","请选择连飞服务器!","error");
		return;
	}
  
  	MainWindowJSObject.connect(strUser, isVIP).then(function (res)
	{
		switch(res) {
			case "Processed":
				swal("请稍候...","提示","info");
				break;
			case "LoggedIn":
				swal("您已连线!","提示","error");
				break;
			case "LoggingIn":
				swal("正在连线中...","提示","error");
				break;
			default:
		}
	});
}

function onDisconnectBtnClicked() {
	MainWindowJSObject.disconnect().then(function (res)
	{
		switch(res) {
			case "NotLoggedIn":
				swal("您未连线!","提示","error");
				break;
			case "Processed":
				swal("断线成功!","提示","success");
				break;
			default:
		}
	});
}


function onExitBtnClicked() {
	MainWindowJSObject.onExitButtonClicked();
}

function onMinimizeBtnClicked() {
	MainWindowJSObject.minimize();
}

function onMiniModeBtnClicked() {
	MainWindowJSObject.miniMode();
}

function onFileFlightplanBtnClicked() {
	var e = document.getElementById("FlightType");
	var flighttype = e.options[e.selectedIndex].value;
	var depIcao = document.getElementById("DepICAO").value;
	var arrIcao = document.getElementById("ArrICAO").value;
	var alternativeIcao = document.getElementById("AlternativeICAO").value;
	var altitude = document.getElementById("Altitude").value;
	var route = document.getElementById("routeTextBox").value;
	var note = document.getElementById("noteTextBox").value;
	var plannedDepTime = document.getElementById("plannedDepTime").value;
	var plannedArrTime = document.getElementById("plannedArrTime").value;
    MainWindowJSObject.fileFlightplan(flighttype, depIcao, arrIcao, alternativeIcao, altitude, route, note, plannedDepTime, plannedArrTime);
}

function toggleATCTS()
{
	MainWindowJSObject.toggleATCTS();
}

function createFrequency()
{
	MainWindowJSObject.createFrequency(document.getElementById("frequencyCreatedText").value);
}

function deleteFrequency()
{
	MainWindowJSObject.deleteFrequency(document.getElementById("frequencyCreatedText").value);
}

function configurePTTKey()
{
	MainWindowJSObject.configurePTTKey();	
}

function shutdownVoice()
{
	MainWindowJSObject.shutdownVoice();	
}

function uploadATIS()
{
	var filename = document.getElementById('file').value;
	MainWindowJSObject.uploadATIS(filename);	
}

function switchTransponderStatus()
{
	MainWindowJSObject.switchTransponderStatus();	
}

function onLoadFlightplanBtnClicked()
{
	MainWindowJSObject.loadLastFlightplan();
}

function onMessageBoxBtnClicked()
{
	MainWindowJSObject.showMessageBox();
}

function onRadarBtnClicked()
{
	MainWindowJSObject.showRadar();
}

function selectOutputDevice()
{
	var index = document.getElementById('outputDevice').selectedIndex;
	MainWindowJSObject.selectOutputDevice(index);
}

function selectInputDevice()
{
	var index = document.getElementById('inputDevice').selectedIndex;
	MainWindowJSObject.selectInputDevice(index);	
}

function testVoice()
{
	MainWindowJSObject.toggleLocalVoiceTest();
}

function changeSpeakerVolume(val)
{
	MainWindowJSObject.changeSpeakerVolume(val);
}