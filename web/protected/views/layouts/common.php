<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>肥皂|中国最大的华裔美少年偶像の社区</title>
<meta content="帅哥,靓仔,校草,演艺圈,经纪公司,演艺经纪,互联网,O2O" name="Keywords" />
<meta property="qc:admins" content="7261517777656512176375" />
<link href="/css/webmag-1.2.css" rel="stylesheet" type="text/css" />
<link href="/css/default_v4.css?v=20141103" rel="stylesheet" type="text/css" />
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

seajs.use('head');

with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];

</script>


<body>
<div id="overlay-mask"></div>
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
          <li class="setting logined" style="display:none;"><a href="#"></a>
            <span class="settingBg"></span><em></em>
            <div class="settingCont">
              <div class="settingLeft fl">
                <dl>
                  <dt><img src="/img/default.jpg" width="80" height="80"></dt>
                  <dd><a href="javascript:void(0)" class="upface">上传头像</a></dd>
                </dl>
              </div>
              <div class="settingRight fl">
                <dl>
                  <dt>管理中心</dt>
                  <dd>
                    <a href="/user/password" class="mPassword">修改密码</a>
                    <a href="/recruitment/step1" class="liveRoom">直播房间</a>
                    <a href="/user/center" class="ucenter">个人中心</a>
                    <a href="/recharge/center" class="store">充值商城</a>
                    <p class="clear"></p>
                  </dd>
                </dl>
              </div>
              <p class="clear"></p>
            </div>
          </li>
          <!--li class="msg posR"><i>10</i><a href="#"></a></li-->
          <li class="edit logined" style="display:none">
            <span class="editBg"></span><em></em>
            <div class="editCont">
              <div class="editInner mar">
                <span>当前昵称： <b></b></span>
                <span>修改昵称： <input type="text" class="fi-nickname" id="newNickname"></span>
                <span class="editBtn"><input type="button" class="btns btn-confirm" id="doEditNickname" value="确定">  <input type="button" class="btns btn-cancel" id="cancelEditNickname" value="取消"></span>
              </div>
              <div class="editNotice">注：修改后，原昵称有可能被抢注</div>
            </div>
          </li>
         <li class="chong ml5 logined" style="display:none;"><a href="/recharge/center">充值</a></li>
          <li class="coin ml5 logined" style="display:none;"><b>10.2</b> 金币</li>
          <li class="uinfo mr10 unlogined"><a href="#" id="user-reg">注册</a> | <a href="#" id="user-login">登录</a></li>
          <li class="uinfo mr10 logined" style="display:none;"><img src="/img/1_s1.jpg" width="25" height="25"> <a href="/user/center" class="nickname">妖精baby（860876）</a>&nbsp;&nbsp;<a href="/user/logout/?callback=<?=urlencode(ToolUtils::getCurrentUrl())?>">退出</a></li>
        </ul>
      </div>
    </div>
    <div class="top-column2">
      <div class="wrap posR">
        <a href="/" class="logo posA"></a>
        <a href="/recruitment/step1" class="topJoin posA" title="我要当练习生"></a>
        <div class="topTime posA"></div>
      </div>
    </div>
    <div class="menuOuter">
      <div class="menuList wrap">
        <a href="/">首&nbsp;&nbsp;页</a>
        <!--<a href="/rank">排行榜</a>-->
        <a href="/recharge/center">充&nbsp;&nbsp;值</a>
        <a href="http://bbs.efeizao.com">论&nbsp;&nbsp;坛</a>
        <a href="/help/about">关于肥皂</a>        
      </div>
    </div>
  </div>
  <!--/header-->


<!--overlay-upface-->
<div id="overlay-upface">
  <div class="overlay-upfaceTitle posR">上传头像<a href="#" class="close2">x</a></div>
  <div class="overlay-upfaceContent">
    <div class="upBox mar" style="display:block">
      <div class="upBoxTab" id="upBoxTab"><a href="#" class="on">本地上传</a> <span>|</span> <a href="#">肥皂推荐</a></div>
      <div class="upBoxLocal mt10" id="upBoxItem0" style="display:block;">
        <div class="addPic taC"><a href="#" id="addPic"></a><br>支持jpg、jpeg、png等格式，文件小于2M。</div>
        <div style="display:none" id="item0Step2">
          <div class="upBoxLocal-left fl">
            <dl style="width:auto">
              <dt style="width:auto;"><img id="uploadImage" style="max-height:265px;max-width:350px;min-height:200px;min-width:200px;"></dt>
              <dd><input type="submit" class="btns btn-1" style="width:75px;height:32px;line-height:32px;" value="上 传" id="uploadHeadPic"> <input type="button" class="btns btn-2" style="width:75px;height:32px;line-height:32px;" value="重 选" id="pickAgain"></dd>
            </dl>
          </div>
          <div class="upBoxLocal-right fl">
            <dl>
              <dd style="height:200px;width:200px;overflow:hidden"><img id="headPreview"/></dd>
              <dd>预览效果</dd>
            </dl>
          </div>
          <p class="clear"></p>
        </div>
      </div>
      <div class="upBoxRecommend" id="upBoxItem1">
        <div class="upBoxRecommend-left fl">
          <dl>
            <span><img src="/css/face200x200.jpg" width=200 height=200 id="reHeadPreview"/></span>
            <dd><input type="submit" class="btns btn-1" style="width:75px;height:32px;line-height:32px;" value="上 传" id="uploadReHeadPic"></dd>
          </dl>
        </div>
        <div class="upBoxRecommend-right fl" id="reHeadPic">
          <img src="/img/face1_s1.jpg" width="50" height="50">
          <img src="/img/face2_s1.jpg" width="50" height="50">
          <img src="/img/face3_s1.jpg" width="50" height="50">
          <img src="/img/face4_s1.jpg" width="50" height="50">
          <img src="/img/face5_s1.jpg" width="50" height="50">
          <img src="/img/face6_s1.jpg" width="50" height="50">
          <img src="/img/face7_s1.jpg" width="50" height="50">
          <img src="/img/face8_s1.jpg" width="50" height="50">
          <img src="/img/face9_s1.jpg" width="50" height="50">
          <img src="/img/face10_s1.jpg" width="50" height="50">
          <img src="/img/face11_s1.jpg" width="50" height="50">
          <img src="/img/face12_s1.jpg" width="50" height="50">
          <img src="/img/face13_s1.jpg" width="50" height="50">
          <img src="/img/face14_s1.jpg" width="50" height="50">
          <img src="/img/face15_s1.jpg" width="50" height="50">
          <img src="/img/face16_s1.jpg" width="50" height="50">
          <img src="/img/face17_s1.jpg" width="50" height="50">
          <img src="/img/face18_s1.jpg" width="50" height="50">
          <img src="/img/face19_s1.jpg" width="50" height="50">
          <img src="/img/face20_s1.jpg" width="50" height="50">
          <img src="/img/face21_s1.jpg" width="50" height="50">
          <img src="/img/face22_s1.jpg" width="50" height="50">
          <img src="/img/face23_s1.jpg" width="50" height="50">
          <img src="/img/face24_s1.jpg" width="50" height="50">
          <img src="/img/face25_s1.jpg" width="50" height="50">
          <img src="/img/face26_s1.jpg" width="50" height="50">
          <img src="/img/face27_s1.jpg" width="50" height="50">
          <img src="/img/face28_s1.jpg" width="50" height="50">
          <img src="/img/face29_s1.jpg" width="50" height="50">
          <img src="/img/face30_s1.jpg" width="50" height="50">
          <img src="/img/face31_s1.jpg" width="50" height="50">
          <img src="/img/face32_s1.jpg" width="50" height="50">
          <img src="/img/face33_s1.jpg" width="50" height="50">
          <img src="/img/face34_s1.jpg" width="50" height="50">
          <img src="/img/face35_s1.jpg" width="50" height="50">
          <img src="/img/face36_s1.jpg" width="50" height="50">
          <img src="/img/face37_s1.jpg" width="50" height="50">
          <img src="/img/face38_s1.jpg" width="50" height="50">
          <img src="/img/face39_s1.jpg" width="50" height="50">
          <img src="/img/face40_s1.jpg" width="50" height="50">
          <p class="clear"></p>
        </div>
        <p class="clear"></p>
      </div>
    </div>
    
  </div>
</div>
<!--/-->


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