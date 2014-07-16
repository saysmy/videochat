<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title></title>
<meta name="description" content="">
<meta name="keywords" content="">
<link href="css/webmag-1.2.css" rel="stylesheet" type="text/css" />
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type='text/javascript' src='js/swfobject.js'></script>
<script type='text/javascript' src='js/popCheckbox.js?v=0.3'></script>
<script src="js/custom.js?v=0.10"></script>
<!--[if IE 6]>
<script src="scripts/DD_belatedPNG_0.0.8a.js"></script>
<script>
  DD_belatedPNG.fix('.rommlogo');
</script>
<![endif]-->
</head>

<body>
<div id="container"> 
  <!--roomHeader-->
  <div id="roomHeader">
    <div class="wrap roomHeader posR">
      <a href="#" class="roomLogo posA"></a>
      <div class="roomOwner">
        <dl>
          <dt><a href="#"><img src="<?=$this->moderatorUserInfo['head_pic_1']?>" width="45" height="45"></a></dt>
          <dd>
            <a href="#">爱的感言：<?=$this->room['moderator_sign']?></a>
            <div class="vinfo">
              <span class="view">458</span>
              <span class="time">120分钟</span>
              <span class="click">174/70</span>
              <span class="share2 ml20"><a href="#"><img src="css/share-qq.gif" width="50" height="16"></a> <a href="#"><img src="css/share-qzone.gif" width="50" height="16"></a></span>
            </div>
          </dd>
        </dl>
      </div>
    </div>
  </div>
  <!--/roomHeader-->

  <!--mainbody-->
  <?=$content?>
  <!--/mainbody-->
  
  <!--footer-->
  <div id="footer" class="mt20">
    <div class="wrap footer">
      <span>&copy;爱美互动科技</span>
      <span class="footerLink"><a href="#">关于爱美</a> | <a href="#">高薪诚聘</a> | <a href="#">友情链接</a> | <a href="#">网站地图</a></span>
      <span>京ICP证060797 京ICP备09082681-1 网络视听许可证0108268 京公安备1101082014405 <a href="#">经营性网站备案信息</a> <a href="#">不良信息举报中心</a></span>
      <span><a href="#">网警110服务</a> 京网文【2010】0489058节目制作许可证 京字第666号 营业性演出许可证京市演1169号</span>
    </div>
  </div>
  <!--/-->
</div>
</body>
</html>
