<!--overlay-->
<script>
var registerLogin = seajs.use('registerLogin');
registerLogin.qqLoginUrl = '<?=CUser::getQQLoginUrl();?>';
</script>
<div id="overlay-mask"></div>
<div id="overlay-cont">
  <!--overlay-reg-->
  <div class="overlay-inner posR" id="overlay-reg">
    <span class="close">x</span>
    <div class="overlay-fm posA">
      <h1>立即注册，就可以跟 <b>帅哥</b> 互动聊天~</h1>
      <form id="register-form">
      <table cellpadding="0" cellspacing="0" width="100%" border="0" id="register-area">
        <tr>
          <td><input name="username" type="text" placeholder="用户名/手机/邮箱" class="fi-txt" autocomplete="off"></td>
        </tr>
        <tr>
          <td>
          <label>年龄
            <select name="age" size="1">
            <?php for($i = 18; $i <= 50; $i ++ ):?>
            <option <?=$i==21?'selected':''?> value="<?=$i?>"><?=$i?></option>
            <?php endfor?>
            </select>
          </label>
          <label>身高
            <select name="height" size="1">
            <?php for($i = 155; $i <= 190; $i ++ ):?>
            <option value="<?=$i?>" <?=$i==178?'selected':''?> value="<?=$i?>"><?=$i?>cm</option>
            <?php endfor?>            
            </select>
          </label>
          <label>体重
            <select name="weight" size="1">
            <?php for($i = 40; $i <= 100; $i ++ ):?>
            <option value="<?=$i?>" <?=$i==63?'selected':''?> value="<?=$i?>"><?=$i?>kg</option>
            <?php endfor?>  
            </select>
          </label>
          </td>
        </tr>
        <tr>
          <td><input name="password" type="password" placeholder="密码" class="fi-txt" autocomplete="off"></td>
        </tr>
        <tr>
          <td><input name="passwordRepeat" type="password" placeholder="确认密码" class="fi-txt"></td>
        </tr>
        <tr>
          <td><input name="captcha" type="text" placeholder="验证码" class="fi-txt medium"><?php $this->widget('CCaptcha',array('captchaAction' => 'user/captcha', 'showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer;float:right;margin-right:80px', 'id' => 'register-captcha'))); ?></td>
        </tr>
        <tr>
          <td id="agree-td"><label><input type="checkbox" id="register-agree" checked name="agree"> 我已阅读并同意</label><a href="#">《网站协议》</a></td>
        </tr>
        <tr>
          <td><input type="submit" class="btns btn-1" value="立即注册"></td>
        </tr>
      </table>
      </form>
    </div>
    <div class="overlay-login posA">
      <h1>已有肥皂帐号 <a href="#" class="overlay-loginBtn">马上登录</a></h1>
      <div class="overlay-quick mtb10"><a href="#"><img src="/img/btn-qq.jpg" width="151" height="36" class="goQQLogin"></a></div>
    </div>
  </div>
  <!--/-->
  <!--overlay-login-->
  <div class="overlay-inner posR" id="overlay-login">
    <span class="close">x</span>
    <div class="overlay-fm posA">
      <h1>立即注册，就可以跟 <b>帅哥</b> 互动聊天~</h1>
      <form id="login-form">
      <table cellpadding="0" cellspacing="0" width="100%" border="0" id="login-area">
        <tr>
          <td><input name="username" type="text" placeholder="用户名/手机/邮箱" class="fi-txt"></td>
        </tr>
        <tr>
          <td><input name="password" type="password" placeholder="密码" class="fi-txt"></td>
        </tr>
        <tr>
          <td><label><input type="checkbox" checked id="login-remember"> 下次自动登录</label></td>
        </tr>
        <tr>
          <td><input type="submit" class="btns btn-1" value="立即登录"></td>
        </tr>
      </table>
      </form>
    </div>
    <div class="overlay-login posA">
      <h1>没有肥皂帐号 <a href="#" class="overlay-regBtn">立即注册</a></h1>
      <div class="overlay-quick mtb10"><a href="#"><img src="/img/btn-qq.jpg" width="151" height="36" class="goQQLogin"></a></div>
    </div>
  </div>
  <!--/-->
</div>
<!--/-->