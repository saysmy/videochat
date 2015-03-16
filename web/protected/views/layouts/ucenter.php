<?php $this->beginContent('//layouts/common'); ?>
  <?php if(!$this->userInfo):?>
  <script>
  $(document.body).ready(function() {
      seajs.use('user', function(user) {
          user.showLoginPanel();
      })
  })
  </script>
  <?php endif?>
  <style>
  .yiiPager {text-align:right;margin-top:4px;}
  .yiiPager li {display:inline;}
  </style>
  
  <!--mainbody-->
  <div id="mainbody_new" class="mt10">
    <div class="pageNav wrap">您当前的位置：<b>个人中心</b> &gt; 我的帐户</div>
    <div class="pageCont borA">
      <div class="pageSidebar">
        <div class="userBox mar">
          <dl>
            <dt><a href="javascript:void(0)"><img src="<?=$this->userInfo['head_pic_1']?$this->userInfo['head_pic_1']:'/img/1_s1.jpg'?>" width="45" height="45"></a></dt>
            <dd>
              <b><?=$this->userInfo['nickname']?></b>
              <span class="vip"><em class="<?=$this->userInfo['vip_level'] == VIP_LEVEL_USER ? 'on' : ''?>"></em></span>
              <?php if($this->userInfo['age']):?>
              <!--<span>(<?=$this->userInfo['age']?>/<?=$this->userInfo['height']?>/<?=$this->userInfo['weight']?>)</span>-->
              <?php endif?>
            </dd>
            <p class="clear"></p>
          </dl>
          <div class="loginHistory mt10">上次登录:<br><?=$this->userInfo['last_login_time']?$this->userInfo['last_login_time']:'无'?> <!--广东-深圳市--></div>
          <div class="userLogout mt10 taR"><a href="/user/logout">退出</a></div>
        </div>
        <div class="userNav mt10">
          <a href="/userCenter" class="unav-1 <?=$this->currentTab == 'gift' ? 'on' : ''?>"><em></em>我的礼物</a>
          <a href="/userCenter/myVip" class="unav-2 <?=$this->currentTab == 'myVip' ? 'on' : ''?>"><em></em>我的会员</a>
          <a href="#" class="unav-3"><em></em>充值记录</a>
          <a href="#" class="unav-4"><em></em>密码管理</a>
          <a href="/userCenter/publishHistory" class="unav-5 <?=$this->currentTab == 'publishHistory' ? 'on' : ''?>"><em></em>我的直播</a>
        </div>
        <!--
        <div class="payService">
          <h2>客服帮助：</h2>
          <span>联系客服：<a href="http://wpa.qq.com/msgrd?v=3&uin=3131657171&site=肥皂网络&menu=yes" target=_blank><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
          <span>联系客服：<a href="http://wpa.qq.com/msgrd?v=3&uin=2627466908&site=肥皂网络&menu=yes" target=_blank><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
        </div>
        -->
      </div>

      <?=$content?>

      <p class="clear"></p>
    </div>
  </div>
  <!--/mainbody-->
<?php $this->endContent(); ?>