<style type="text/css">
  .wrapper {position: relative;}
  #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;}
</style>

<div class="wrapper">
  <textarea id="input">这是幕后黑手</textarea>
  @inject('vasvc','App\Services\VirtualAirlineService')
  @foreach($vasvc->getAirlines() as $airline)
    <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('http://va.hkrscoc.com/index.php/Airlines/airline/{{$airline->code}}')">
      {{$airline->code}}<br /> <img width='48' height='48' src="http://va.hkrscoc.com/images/Airlineslogo/{{$airline->code}}/{{$airline->code}}OK.jpg"/><br />{{$airline->gspv}}
    </button>
  @endforeach

  <br /> <br /><b>停运的航空公司将不显示公司信息 \ 未显示LOGO 公司未上传</b> <br />
</div>
<script type="text/javascript">
  function copyText(content) {
    text = content;
    var input = document.getElementById("input");
    input.value = text; // 修改文本框的内容
    input.select(); // 选中文本
    document.execCommand("copy"); // 执行浏览器复制命令
    alert("复制成功，粘贴至浏览器打开");
  }
</script>