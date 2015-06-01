<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>肥皂|中国最大的华裔美少年偶像の社区</title>
<meta content="帅哥,靓仔,校草,演艺圈,经纪公司,演艺经纪,互联网,O2O" name="Keywords" />
<meta property="qc:admins" content="7261517777656512176375" />
<link href="/css/webmag-1.2.css" rel="stylesheet" type="text/css" />
<link href="/css/default_v4.css?v=20150601" rel="stylesheet" type="text/css" />
<link href="/css/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/js/jquery.min.js'></script>
<script type='text/javascript' src="/js/sea.min.js"></script>
<style>
.jcrop-holder {
    margin:auto;
}
</style>

<!--[if IE 6]>
<script src="/js/DD_belatedPNG_0.0.8a.js"></script>
<script>
  DD_belatedPNG.fix('.topstar');
</script>
<![endif]-->
</head>
<script>
document.domain = '<?=MAIN_DOMAIN?>';
<?php global $seaFiles;?>
seajs.config({
  base: "/js/",
  alias: {
    <?php foreach($seaFiles as $key => $file):?>
    '<?=$key?>' : '<?=$file?>',
    <?php endforeach;?>
    '' : ''
  }
})

<?php global $jsDefine;?>
<?php foreach($jsDefine as $name => $val):?>
<?=$name?> = "<?=$val?>";
<?php endforeach;?>

</script>


<body>

<div id="container" class="mar">

  <?php require('head.php');?>

  <div class="top-column2">
    <div class="wrap posR">
      <a href="/" class="logo posA"></a>
      <a href="/recruitment/step1" class="topJoin posA" title="我要当练习生"></a>
      <div class="topTime posA"></div>
    </div>
  </div>
  <div class="menuOuter">
    <div class="menuList wrap">
      <a href="/">首 页</a>
      <a href="http://bbs.<?=MAIN_DOMAIN?>" target=_blank>论 坛</a>
      <!--<a href="/rank">排行榜</a>-->
      <a href="/recharge/center">充 值</a>
      <a href="/help/about">关 于</a>        
    </div>
  </div>


  <!--mainbody-->
  <?=$content?>
  <!--/mainbody-->

  <!--footer-->
  <div id="footer" class="mt20">
    <div class="wrap footer">
      <span>&copy;肥皂网络科技</span>
      <span class="footerLink"><a href="/help/about">关于肥皂</a> | <a href="/help/employ">高薪诚聘</a> | <a href="/help/link">友情链接</a> | <a href="/help/map">网站地图</a></span>
      <span>粤ICP证060797 粤ICP备09082681-1 网络视听许可证0108268 粤公安备1101082014405 <a href="http://www.hd315.gov.cn/">经营性网站备案信息</a> <a href="http://net.china.com.cn/index.htm">不良信息举报中心</a></span>
      <span><a href="http://www.szga.gov.cn/">网警110服务</a> 粤网文【2010】0489058节目制作许可证 粤字第666号 营业性演出许可证京市演1169号</span>
    </div>
  </div>
  <!--/-->
</div>
</body>
</html>

<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F865d58598d9617e82f15d449bb7b98bb' type='text/javascript'%3E%3C/script%3E"));
</script>
