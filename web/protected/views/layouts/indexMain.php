<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>肥皂网-宽容似海，不提伤害</title>
<meta content="京东JD.COM-专业的综合网上购物商城，在线销售家电、数码通讯、电脑、家居百货、服装服饰、母婴、图书、食品、在线旅游等数万个品牌千万种优质商品。便捷、诚信的服务，为您提供愉悦的网上商城购物体验! " name="description">
<meta content="帅哥,靓仔,校草,直男,玉男,男人,男色,小鲜肉,肌肉,GAY,王力宏,视频主播,视频秀,主播,配件,手表,交友,泡草网" name="Keywords">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/webmag-1.2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/default.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.min.js?v=1.9.1'></script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/layer/layer.min.js'></script>
<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/common.js'></script>
<!--[if IE 6]>
<script src="scripts/DD_belatedPNG_0.0.8a.js"></script>
<script>
  DD_belatedPNG.fix('.topstar');
</script>
<![endif]-->
</head>
<script>
    $(document.body).ready(function() {
        $('#goQQLogin').click(function() {
            qqLogin('<?=$this->loginUrl?>');
        })
        $(".vlist > li:eq(1)").css({"margin-bottom":"10px"});
        $(".vlist > li:nth-child(2n)").css({"margin-left":"10px"});
        
        $(".vlist2 > dl:nth-child(4n)").css({"margin-right":"0"})
        
        $(".roomHot li:lt(3) em").css({"background":"#4598da"});
        $(".roomHot li:lt(3) a").css({"font-weight":"bold"});
    })
</script>
<body>
<div id="container" class="mar"> 
  <!--header-->
  <div id="header">
    <div class="top-column1">
      <div class="wrap topbar">
        <ul>
          <li class="qqlogin <?=$this->qqLoginDisplay?>"><a href="#" id="goQQLogin"><img src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_7.png"></a></li>
          <li class="mail <?=$this->uInfoDisplay?>"><a href="#"></a></li>
          <li class="setting  <?=$this->uInfoDisplay?>"><a href="#"></a></li>
          <li class="msg posR  <?=$this->uInfoDisplay?>"><i>10</i><a href="#"></a></li>
          <li class="edit  <?=$this->uInfoDisplay?>"><a href="#"></a></li>
          <li class="chong ml5  <?=$this->uInfoDisplay?>"><a href="#">充值</a></li>
          <li class="coin ml5  <?=$this->uInfoDisplay?>"><b><?php echo isset($this->uInfo['coin']) ? $this->uInfo['coin'] : 0;?></b>金币</li>
          <li class="uinfo  <?=$this->uInfoDisplay?>"><img src="<?php echo isset($this->uInfo['head_pic_1']) ? $this->uInfo['head_pic_1'] : '';?>" width="25" height="25"> <a href="#"><?php echo isset($this->uInfo['nickname']) ? $this->uInfo['nickname'] : '';?></a></li>
        </ul>
      </div>
    </div>
    <div class="top-column2">
      <div class="wrap posR" style="height:140px;">
        <a href="#" class="logo posA"></a>
        <div class="menu posA">
          <a href="#">首 页</a>
          <a href="#">个人中心</a>
          <a href="#">排行榜</a>
          <a href="#">充值中心</a>
          <a href="#">帮助中心</a>
        </div>
        <div class="search posA">
          <input type="text" class="isearch" placeholder="搜索你喜欢的男主播...">
          <input type="button" class="btns btn-search" value="搜 索">
        </div>
        <a href="#" class="collect posA">收藏</a>
        <a href="#" class="share posA">分享</a>
      </div>
    </div>
  </div>
  <!--/header-->
  <?php echo $content;?>
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
