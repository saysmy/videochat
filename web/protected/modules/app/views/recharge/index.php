<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8">
<meta name="viewport" content="target-densitydpi=device-dpi,width=device-width,initial-scale=1,user-scalable=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<meta content="email=no" name="format-detection" />
<link href="<?=$this->module->assetsUrl?>/css/webmag-1.2.css" rel="stylesheet">
<link href="<?=$this->module->assetsUrl?>/css/default.css" rel="stylesheet">
</head>

<body>
<div id="container">
  <!--
  <div id="header" class="posR">
    <a href="#" class="top-back posA"></a>
    <div class="top-title posA">肥皂币充值</div>
  </div>
-->
  <div id="mainbody">
    <!-- <div class="blank"></div> -->
    <div class="recharge-account">
      <h1>当前金额/肥皂币</h1>
      <div class="num posA" id="coin">0.00</div>
    </div>
    <div class="recharge-money wrap">
      <h2>充值金额</h2>
      <ul>
        <li class="check" amount="10"><a href="javascript:void(0)">10元（10肥皂币）</a></li>
        <li class="odd" amount="30"><a href="javascript:void(0)">30元（30肥皂币）</a></li>
        <li amount="50"><a href="javascript:void(0)">50元（50肥皂币）</a></li>
        <li class="odd" amount="100"><a href="javascript:void(0)">100元（100肥皂币）</a></li>
        <li amount="300"><a href="javascript:void(0)">300元（300肥皂币）</a></li>
        <li class="odd" amount="500"><a href="javascript:void(0)">500元（500肥皂币）</a></li>
        <li amount="1000"><a href="javascript:void(0)">1000元（1000肥皂币）</a></li>
        <li class="odd" amount="5000"><a href="javascript:void(0)">5000元（5000肥皂币）</a></li>
        <p class="clear"></p>
      </ul>
      <div class="recharge-btn mtb10">
        <a href="javascript:void(0)" class="btns btn-pay" id="goToPay"><span>立即支付</span></a>
      </div>
    </div>
  </div>
</div>
</body>
<script src="<?=$this->module->assetsUrl?>/scripts/jquery.min.js"></script>
<script src="<?=$this->module->assetsUrl?>/scripts/custom.js"></script>
<script src="<?=$this->module->assetsUrl?>/scripts/common.js"></script>
<script>
  var logined = <?=$userInfo ? 'true' : 'false'?>;
  var coin = <?=$userInfo ? $userInfo->coin : '0'?>;
  if (!logined) {
    var os = getOS();
    if (os == 'android') {
      recharge.needLogin();
    }
  }
  else {
    $('#coin').text(coin);
    $('li[amount]').click(function() {
      $('li.check').removeClass('check');
      $(this).addClass('check');
    })
    $('#goToPay').click(function() {
      location.href='/app/recharge/alipay/money/' + $('li.check').attr('amount') + '/platform/' + getOS();
    })    
  }
</script>


</html>