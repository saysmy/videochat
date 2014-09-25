  <div id="mainbody_new" class="mt10">
    <div class="paySucess wrap">
      <div class="paySucessTitle ptb10"><span><?php if($success){ echo '恭喜你，充值成功！';}else{echo '充值失败';}?></span></div>
      <div class="paySucessInfo mt10">
        <dl>
          <dt>订单编号：<?=$alipayTradeNo?><br>充值渠道：支付宝（非直连）<br>充值账号：<?=$nickname?><br>充值产品：泡泡币<br>充值金额：<b><?=$coin?></b>泡泡<br>充值时间：<?=$payTime?><br>充值结果：<?php if($success){ echo '<b>充值成功</b>';}else{echo '<i>充值失败</i>';}?><br><br><a href="/recharge/center" class="btns btn-1 dispB">继续充值</a></dt>
          <dd>
            <h1>客服帮助：</h1>
            <span>联系客服：<a href="#"><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
            <span>联系客服：<a href="#"><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
          </dd>
          <p class="clear"></p>
        </dl>
      </div>
    </div>
  </div>
