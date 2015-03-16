      <div class="pageContent">
        <div class="userCont">
          <h1>我的会员</h1>
          <div class="userMember">
            <dl>
              <dt></dt>
              <dd><h2>会员</h2><span>29.9肥皂币/月 &nbsp;&nbsp;<a href="#" class="btns btn-3" id="btn-buy">购买</a></span></dd>
            </dl>
          </div>
          <h1>会员特权</h1>
          <div class="userPri clearfix mt20">
            <dl>
              <dt class="pri-1"></dt>
              <dd><h2>客服特别通道</h2><p>专属客服专属服务，更方便贴心</p></dd>
            </dl>
            <dl>
              <dt class="pri-2"></dt>
              <dd><h2>蓝色昵称</h2><p>专属昵称颜色，让您时刻与众不同</p></dd>
            </dl>
            <dl>
              <dt class="pri-3"></dt>
              <dd><h2>排名靠前</h2><p>尊贵身份，排名靠前</p></dd>
            </dl>
            <dl>
              <dt class="pri-4"></dt>
              <dd><h2>尊贵勋章</h2><p>专属勋章，尊贵身份时刻彰显</p></dd>
            </dl>
            <dl>
              <dt class="pri-5"></dt>
              <dd><h2>防被踢</h2><p>乐享直播，不受干扰</p></dd>
            </dl>
          </div>
        </div>
      </div>

      <!--ucenter-overlay-->
      <div class="ucenter-overlay posR">
        <a href="#" class="buy-close"></a>
        <div class="ucenter-buy posA clearfix">
          <div class="ucenter-buy-left">
            <dl>
              <dt></dt>
              <dd>
                <h2>会员</h2>
                <span>29.9肥皂币/月</span>
              </dd>
            </dl>
            <div class="ucenter-buy-info mt10">
              <span>按月购买：30天/月<br>按年购买：365天/年</span>
              <span>商品有效期内购买本商品，有效期累加。其他情况，有效期从购买时起算。</span>
            </div>
          </div>
          <div class="ucenter-buy-right">
            <h2>开通账号：<b><?=$this->userInfo['nickname']?></b></h2>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <th>购买方式：</th>
                <td><a href="#" class="buy-time on" time="month">按月计费</a> <a href="#" class="buy-time" time="year">按年计费</a></td>
              </tr>
              <tr>
                <th>购买时长：</th>
                <td>
                    <div class="buy-num buy-month"><input type="text" class="fi-txt buy-month-num" placeholder="1" value="1"> 个月</span></div>
                    <div class="buy-num buy-year dispN"><input type="text" class="fi-txt buy-year-num" placeholder="1" value="1"> 年</div>
                  </td>
              </tr>
              <tr>
                <th>应付金额：</th>
                <td>
                    <span><b class="need-pay">29.9</b>肥皂币 账户余额<b class="my-coin"><?=$this->userInfo['coin']?></b>肥皂币</span>
                    <span class="buy-error" style="display:none;">余额不足，缺少<num class="error-num">89.7</num>肥皂币 <a href="/recharge/center">去购买</a></span>
                  </td>
              </tr>
              <tr>
                <th></th>
                <td><input type="submit" class="btns btn-buy" value="购买" id="vip-buy"></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <!--/-->

      <script>
      seajs.use('userCenterMyVip');
      </script>


