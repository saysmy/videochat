  <script>
  $(document.body).ready(function() {
      var logined = true;
      <?php if(!$userInfo):?>
        logined = false;
      <?php endif?>  

      $('#other-amount').focus(function() {
          $('input[name=amount][value=other]')[0].checked = true;
      })

      $('#do-recharge').click(function() {
          if (!logined) {
              seajs.use('user', function(r) {
                r.showLoginPanel();
              })
              return false;
          }

          if ($('input[name=amount]:checked').val() == 'certain') {
              var money = $('#certain-amount').val();
          }
          else {
              var money = $('#other-amount').val();
          }
          money = parseFloat($.trim(money));
          if (!money || money < 0) {
              layer.msg('充值金额非法');
              return false;
          }

          $("#overlay-mask").height($(document).height());
          $("#overlay-mask").fadeIn();
          $("#overlay-pay").fadeIn();

          $(this).attr('href', '/recharge/alipay/money/' + money);
          return true;
      })

      $("#alipay").click(function(){
          $("#nbank").removeClass("on");
          $(this).addClass("on");
          $(".nbankList").css({"display":"none"});
          return false;
      })
      $("#nbank").click(function(){
          $("#alipay").removeClass("on");
          $(this).addClass("on");
          $(".nbankList").css({"display":"block"})
          return false;
      })

    //支付弹窗
    $("#overlay-pay").css({
        'left':(($(document).width())-500)/2,
        'top':(($(window).height())-280)/2
    });
    $(".close2").click(function(){
        $("#overlay-mask").fadeOut();
        $("#overlay-pay").fadeOut();  
    })

    $("#overlay-pay .btns").click(function(){
        $("#overlay-mask").fadeOut();
        $("#overlay-pay").fadeOut();        
    })

  })
  </script>

<!--overlay-pay-->
<div id="overlay-pay" style="height:220px">
  <div class="overlay-payTitle posR">付款中<a href="#" class="close2">x</a></div>
  <div class="overlay-payContent">
    <span>请根据你的情况点击以下按钮。</span>
    <span><input type="button" value="已完成付款，继续充值" class="btns btn-1"> &nbsp;&nbsp; <input type="button" value="遇到问题，再次尝试" class="btns btn-2"></span>
  </div>
</div>
<!--/-->

  <!--mainbody-->
  <div id="mainbody_new">
    <div class="pageNav wrap">您当前的位置：<b>充值中心</b> &gt; 泡泡币</div>
    <div class="pageCont borA">
      <div class="pageSidebar">
        <div class="payBox">
          <h1>充值泡泡币</h1>
          <span>1泡泡=1元/人民币</span>
          <p>泡泡是你在本平台消费的虚拟货币，你可以通过充值中心充值获得，然后到主播房间进行送礼物，点歌等。</p>
        </div>
        <div class="payService">
          <h2>客服帮助：</h2>
          <span>联系客服：<a href="http://wpa.qq.com/msgrd?v=3&uin=3131657171&site=肥皂网络&menu=yes" target=_blank><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
          <span>联系客服：<a href="http://wpa.qq.com/msgrd?v=3&uin=2627466908&site=肥皂网络&menu=yes" target=_blank><img src="/img/btn_qq.jpg" width="83" height="23"></a></span>
        </div>
      </div>
      <div class="pageContent">
        <div class="payFm">
          <div class="alipay">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th width="20%">当前登录帐号：</th>
                <td><b><?=$userInfo['nickname']?></b></td>
            </tr>
            <tr>
                <th>当前充值方式：</th>
                <td><div class="payItem"><a href="#" class="on" id="alipay"><em></em>支付宝</a><!--<a href="#" id="nbank"><em></em>网银</a>--></div></td>
            </tr>
            <tr>
                <th>选择充值金额：</th>
              <td><input type="radio" checked name="amount" value="certain"> <select name="select2" id="certain-amount">
                <option value="5" selected>5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="300">300</option>
                <option value="500">500</option>
                <option value="1000">1000</option>
                <option value="2000">2000</option>
                <option value="3000">3000</option>
                <option value="5000">5000</option>
                <option value="10000">10000</option>
                <option value="20000">20000</option>
                <option value="50000">50000</option>
                </select> 
                元&nbsp;&nbsp;
                <input type="radio" name="amount" value="other"> 
                其他金额
                <input type="text" class="fi-txt short" id="other-amount">
              </td>
            </tr>
          </table>
          </div>
          <div class="nbankList mt10">
            <h1>网银支付：</h1>
            <ul>
              <li><label><input type="radio"> 
                <img src="/img/bank/beijing.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/beinongcun.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/fudian.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/gongshang.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/guangda.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/guangfa.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/hangzhou.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/jianhang.jpg" width="135" height="30"></label>
              </li>
              
              <li><label><input type="radio"> 
                <img src="/img/bank/jiaohang.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/minsheng.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/ningbo.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/nonghang.jpg" width="135" height="30"></label>
              </li>
              
              <li><label><input type="radio"> 
                <img src="/img/bank/pingan.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/pufa.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/shanghai.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/shenfazhan.jpg" width="135" height="30"></label>
              </li>
              
              <li><label><input type="radio"> 
                <img src="/img/bank/xingye.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/youzheng.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/zhaoshang.jpg" width="135" height="30"></label>
              </li>
              <li><label><input type="radio"> 
                <img src="/img/bank/zhonghang.jpg" width="135" height="30"></label>
              </li>
              
              <li><label><input type="radio"> 
                <img src="/img/bank/zhongxin.jpg" width="135" height="30"></label>
              </li>
              <p class="clear"></p>
            </ul>
          </div>
          <div class="payBtn ptb10"><a href="#" target=_blank id="do-recharge"><input type="submit" class="btns btn-1" value="立即支付" id="btnPay"></a></div>
        </div>
      </div>
      <p class="clear"></p>
    </div>
  </div>
  <!--/mainbody-->