<style type="text/css">
  .wrapper {position: relative;}
  #input {position: absolute;top: 0;left: 0;opacity: 0;z-index: -5;}
</style>
<div class="wrapper">
  <textarea id="input">这是幕后黑手</textarea>

  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('30253708')">航空人生 模拟飞行</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('372807361')">官方 联飞群</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('228425134')">飞行学院</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('601219163')">空管管制学院</button>
  <br />
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('117175590')">Prepar3D</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('141097498')">X-Plane</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('131057650')">FlightGear</button>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('636466140')">平台接入合作</button>
  <br /><br />
  <?php
  /*
  require_once(dirname(__FILE__)."/conn_va.php");
  $query=mysql_query("select * from phpvms_airlines  where enabled=1 ",$conn_va);
  while($airlines = mysql_fetch_assoc($query)){
  ?>
  <button style="margin-bottom:4px; margin-top:4px;" onclick="copyText('<?=$airlines["qq"]?>')"><?=$airlines["name"]?></button>
  <?php
  }
      */
  ?>

  <br /><br />
  <button style="margin-bottom:4px; margin-top:4px; margin-left:3px; margin-right:3px;" onclick="copyText('26923379')">上海浦东分部</button>
</div><br />
<b>停运的航空公司将不显示公司信息</b> 
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
