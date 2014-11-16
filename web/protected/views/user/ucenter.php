  <?php if(!$userInfo):?>
  <script>
  $(document.body).ready(function() {
      seajs.use('registerLogin', function(r) {
          r.showLoginPanel();
      })
  })
  </script>
  <?php endif?>
  <style>
  .yiiPager {text-align:right;margin-top:4px;}
  .yiiPager li {display:inline;}
  </style>
  <!--mainbody-->
  <div id="mainbody_new">
    <div class="pageNav wrap">您当前的位置：<b>个人中心</b> &gt; 我的帐户</div>
    <div class="pageCont borA">
      <div class="pageSidebar">
        <div class="userBox mar">
          <dl>
            <dt><a href="#"><img src="<?=$userInfo['head_pic_1']?$userInfo['head_pic_1']:'/img/1_s1.jpg'?>" width="45" height="45"></a></dt>
            <dd>
              <b><?=$userInfo['nickname']?></b>
              <?php if($userInfo['age']):?>
              <span>(<?=$userInfo['age']?>/<?=$userInfo['height']?>/<?=$userInfo['weight']?>)</span>
              <?php endif?>
            </dd>
            <p class="clear"></p>
          </dl>
          <div class="loginHistory mt10">上次登录:<br><?=$userInfo['last_login_time']?$userInfo['last_login_time']:'无'?> <!--广东-深圳市--></div>
          <div class="userLogout mt10 taR"><a href="/user/logout">退出</a></div>
        </div>
        <div class="payService">
          <h2>客服帮助：</h2>
          <span>联系客服：<a href="http://wpa.qq.com/msgrd?v=3&uin=3131657171&site=肥皂网络&menu=yes" target=_blank><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
          <span>联系客服：<a href="http://wpa.qq.com/msgrd?v=3&uin=2627466908&site=肥皂网络&menu=yes" target=_blank><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
        </div>
      </div>
      <div class="pageContent">
        <div class="userInfo mar">
          <dl>
            <dt>您的账户余额：<b><?=$userInfo['coin']?></b>泡泡</dt>
            <dd><a href="/recharge/center" class="btns btn-1">立即充值</a></dd>
            <p class="clear"></p>
          </dl>
        </div>
        <div class="userConsume mar">
          <h1>您的消费明细：</h1>
          <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
              <th>赠送人</th>
              <th>消费时间</th>
              <th>物品</th>
              <th>数量</th>
              <th>支付泡泡</th>
            </tr>
          <?php if(!$userInfo['consume']):?>
            <tr>
              <td colspan="5"><div class="userConsumeNull">暂时没有记录！</div></td>
            </tr>
            <?php else:?>
            <?php foreach($userInfo['consume'] as $i):?>
            <tr>
                <td><b><?=$userInfo['nickname']?></b></td>
                <td><?=$i['time']?></td>
                <td><?=$i->property['name']?></td>
                <td><?=$i['pnum']?></td>
                <td><?=$i['cost']?></td>
            </tr>
            <?php endforeach?>
          <?php endif?>
          </table>
<?php
 $this->widget('CLinkPager',array(
        'pages' => new CPagination($userInfo['consume_total']), 
        'pageSize' => 10,
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'nextPageLabel' => '>',
        'prevPageLabel' => '<',
        'header' => '',
        'cssFile' => false,
    )
 );
?>
          <!--<div class="page mt10 taR"><a href="#">&lt;</a> <a href="#" class="on">1</a> <a href="#">2</a> <a href="#">&gt;</a></div>-->
        </div>
      </div>
      <p class="clear"></p>
    </div>
  </div>
  <!--/mainbody-->