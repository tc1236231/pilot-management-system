<style type="text/css">
  .wrapper {position: relative;}
  #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -5;}
</style>
<div class="wrapper">
  <textarea id="input">这是幕后黑手</textarea>
<b>【 官方群 】</b>
<br />
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('30253708')">官方模飞群</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('636466140')">官方连飞群</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('228425134')">飞行学院</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('497090390')">空管中心群</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('572276186')">加入团队群</button>
<br /><br />
<b>【 航空公司群 】</b>
<br />
  @inject('vasvc','App\Services\VirtualAirlineService')
  @foreach($vasvc->getAirlines() as $airline)
    <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('{{$airline->qq}}')">
      {{$airline->name}}<br />QQ群：{{$airline->qq}}
    </button>
  @endforeach
<br /><br />
  <b>【 区域分部群 】</b>
<br />
  <button style="margin-bottom:4px; margin-top:4px; margin-left:3px; margin-right:3px;" onclick="copyText('26923379')">上海浦东分部</button>
</div><br />

<script type="text/javascript">
  function copyText(content) {
    // var text = document.getElementById("text").innerText;
    text = content;
    var input = document.getElementById("input");
    input.value = text; // 修改文本框的内容
    input.select(); // 选中文本
    document.execCommand("copy"); // 执行浏览器复制命令
    alert("复制成功");
  }
</script>
