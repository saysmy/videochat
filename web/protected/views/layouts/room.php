<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8>
<title>肥皂|中国最大的华裔美少年偶像の社区</title>
<meta content="帅哥,靓仔,校草,演艺圈,经纪公司,演艺经纪,互联网,O2O" name="Keywords" />
<link href="/css/webmag-1.2.css" rel="stylesheet" type="text/css" />
<link href="/css/default.css?v=0.2" rel="stylesheet" type="text/css" />
<script type='text/javascript' src='/js/jquery.min.js?v=1.9.1'></script>
<script type='text/javascript' src='/js/swfobject.js'></script>
<script type='text/javascript' src='/js/raphael-min.js'></script>
<script type='text/javascript' src="/js/sea.min.js"></script>
<!--[if IE 6]>
<script src="scripts/DD_belatedPNG_0.0.8a.js"></script>
<script>
  DD_belatedPNG.fix('.rommlogo');
</script>
<![endif]-->
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


seajs.use('room');
</script>
</head>

<body>

<div id="container"> 
  <!--roomHeader-->
  <div id="roomHeader">
    <div class="wrap roomHeader posR">
      <a href="/" class="roomLogo posA"></a>
      <div class="roomOwner">
        <dl>
          <dt><a href="#"><img src="<?=$this->moderatorUserInfo['head_pic_1']?>" width="45" height="45"></a></dt>
          <dd>
            <a href="#">爱的感言：<?=$this->room['moderator_sign']?></a>
            <div class="vinfo">
              <span class="view">458</span>
              <span class="time">120分钟</span>
              <span class="click"><?=$this->moderatorUserInfo['height']?>/<?=$this->moderatorUserInfo['weight']?></span>
              <script type="text/javascript">
              (function(){
              var p = {
              url:location.href, /*获取URL，可加上来自分享到QQ标识，方便统计*/
              desc:'主播好帅哦', /*分享理由(风格应模拟用户对话),支持多分享语随机展现（使用|分隔）*/
              title:'肥皂网-宽容似海，不提伤害', /*分享标题(可选)*/
              summary:'', /*分享摘要(可选)*/
              pics:'<?=$this->moderatorUserInfo['head_pic_1']?>', /*分享图片(可选)*/
              flash: '', /*视频地址(可选)*/
              site:'', /*分享来源(可选) 如：QQ分享*/
              style:'103',
              width:50,
              height:16
              };
              var s = [];
              for(var i in p){
              s.push(i + '=' + encodeURIComponent(p[i]||''));
              }
              document.write(['<a class="qcShareQQDiv" href="http://connect.qq.com/widget/shareqq/index.html?',s.join('&'),'" target="_blank">分享到QQ</a>'].join(''));
              })();
              </script>
              <script src="http://connect.qq.com/widget/loader/loader.js" widget="shareqq" charset="utf-8"></script>
              <script type="text/javascript">
              (function(){
              var p = {
              url:location.href,
              showcount:'0',/*是否显示分享总数,显示：'1'，不显示：'0' */
              desc:'主播好帅哦',/*默认分享理由(可选)*/
              summary:'',/*分享摘要(可选)*/
              title:'肥皂网-宽容似海，不提伤害',/*分享标题(可选)*/
              site:'',/*分享来源 如：腾讯网(可选)*/
              pics:'<?=$this->moderatorUserInfo['head_pic_1']?>', /*分享图片的路径(可选)*/
              style:'103',
              width:135,
              height:16
              };
              var s = [];
              for(var i in p){
              s.push(i + '=' + encodeURIComponent(p[i]||''));
              }
              document.write(['<a version="1.0" class="qzOpenerDiv" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'" target="_blank">分享</a>'].join(''));
              })();
              </script>
              <script src="http://qzonestyle.gtimg.cn/qzone/app/qzlike/qzopensl.js#jsdate=20111201" charset="utf-8"></script>
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
