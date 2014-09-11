<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>肥皂网-宽容似海，不提伤害</title>
<meta content="帅哥,靓仔,校草,直男,玉男,男人,男色,小鲜肉,肌肉,GAY,王力宏,视频主播,视频秀,主播,配件,手表,交友,泡草网" name="Keywords">
<link href="/css/webmag-1.2.css" rel="stylesheet" type="text/css" />
<link href="/css/default_v4.css" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/js/jquery.min.js?v=1.9.1'></script>
<script type='text/javascript' src='/js/layer/layer.min.js'></script>
<script type='text/javascript' src="/js/sea.js"></script>

<!--[if IE 6]>
<script src="/js/DD_belatedPNG_0.0.8a.js"></script>
<script>
  DD_belatedPNG.fix('.topstar');
</script>
<![endif]-->
</head>

<script>

seajs.use(['user', 'registerLogin'], function(user, registerLogin) {
    $(document.body).ready(function() {
        user.getUserInfo(function(resp) {
            if (resp.errno) {return;};
            $('.coin b').text(resp.data.coin);
            $('.uinfo.logined img').attr('src', resp.data['head_pic_1']);
            $('.uinfo.logined a').text(resp.data['nickname']);
            $('.logined').show();
            $('.unlogined').hide();
        })
        $("#user-reg").click(registerLogin.showRegisterPanel);
        $("#user-login").click(registerLogin.showLoginPanel);

    })
});

with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];


function addFavorite(sURL, sTitle)
{
    try
    {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e)
        {
            alert("请使用Ctrl+D进行添加(mac用户使用Command+D)");
        }
    }
}
</script>


<body>

<?php $this->beginWidget('application.widgets.RegisterLogin'); ?>
<?php $this->endWidget(); ?>
<div id="container" class="mar"> 
  <!--header-->
  <div id="header">
    <div class="top-column1">
      <div class="wrap topbar">
        <ul>
          <li class="share">
          <div class="bdsharebuttonbox" data-tag="share_1">
          <a class="bds_more" data-cmd="more" style="line-height:34px;float:none;color:rgb(0, 153, 204)">分享</a>
          </div>
          </li>
          <li class="fav"><a href="javascript:addFavorite(location.href,'肥皂网-宽容似海，不提伤害')">收藏</a></li>
          <li class="setting logined" style="display:none;"><a href="#"></a></li>
          <!--li class="msg posR"><i>10</i><a href="#"></a></li-->
          <li class="edit logined" style="display:none;"><a href="#"></a></li>
          <li class="chong ml5 logined" style="display:none;"><a href="/recharge/center">充值</a></li>
          <li class="coin ml5 logined" style="display:none;"><b>10.2</b> 金币</li>
          <li class="uinfo mr10 unlogined"><a href="#" id="user-reg">注册</a> | <a href="#" id="user-login">登录</a></li>
          <li class="uinfo mr10 logined" style="display:none;"><img src="/img/1_s1.jpg" width="25" height="25"> <a href="#">妖精baby（860876）</a></li>
        </ul>
      </div>
    </div>
    <div class="top-column2">
      <div class="wrap posR">
        <a href="/" class="logo posA"></a>
        <div class="topTime posA"></div>
      </div>
    </div>
    <div class="menuOuter">
      <div class="menuList wrap">
        <a href="/">网站首页</a>
        <a href="/user/center">个人中心</a>
        <a href="#">排行榜</a>
        <a href="/recharge/center">充值中心</a>
        <a href="#">帮助中心</a>
      </div>
    </div>
  </div>
  <!--/header-->

  <!--mainbody-->
  <?=$content?>
  <!--/mainbody-->

  <!--footer-->
  <div id="footer" class="mt20">
    <div class="wrap footer">
      <span>&copy;肥皂网络科技</span>
      <span class="footerLink"><a href="#">关于爱美</a> | <a href="#">高薪诚聘</a> | <a href="#">友情链接</a> | <a href="#">网站地图</a></span>
      <span>京ICP证060797 京ICP备09082681-1 网络视听许可证0108268 京公安备1101082014405 <a href="#">经营性网站备案信息</a> <a href="#">不良信息举报中心</a></span>
      <span><a href="#">网警110服务</a> 京网文【2010】0489058节目制作许可证 京字第666号 营业性演出许可证京市演1169号</span>
    </div>
  </div>
  <!--/-->
</div>
</body>
</html>