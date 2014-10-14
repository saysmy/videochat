  <!--mainbody-->
  <div id="mainbody_new" class="mt20">
    <div class="recruitment wrap">
      <h1>应聘练习生流程</h1>
      <div class="step step4"></div>
      <div class="recruitment-block">
        <div class="recruitment-content fl">
          <div class="recruitment-info">
            <div class="recruitment-face"><img heigh=200 width=200 src="<?=$user['head_pic_1']?>"/></div>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="mt20">
              <tr>
                <th>你的昵称：</th>
                <td><?=$user['nickname']?></td>
              </tr>
              <tr>
                <th>真实姓名：</th>
                <td><?=$rec->name?></td>
              </tr>
              <tr>
                <th>基本情况：</th>
                <td><?=$rec->age?>/<?=$rec->height?>/<?=$rec->weight?></td>
              </tr>
              <tr>
                <th>身份证号码：</th>
                <td><?=$rec->id_card?></td>
              </tr>
              <tr>
                <th>QQ号码：</th>
                <td><?=$rec->qq?></td>
              </tr>
              <tr>
                <th>邮箱：</th>
                <td><?=$rec->email?></td>
              </tr>
              <tr>
                <th>手机号码：</th>
                <td><?=$rec->mobile?></td>
              </tr>
            </table>
          </div>
          <ul class="recruitment-imgList mt20">
            <?php foreach(json_decode($rec->images, true) as $k => $url):?>
              <li<?=$k%4==3?' style="margin-right:0px"':''?>><span><img src="<?=$url?>"></span></li>
            <?php endforeach?>
            <p class="clear"></p>
          </ul>
          <div class="mt20"><input type="submit" class="btns btn-1" id="step4Next" value="确认并提交"> &nbsp;&nbsp;<a href="step3"><input type="submit" class="btns btn-2" value="返回修改"></a></div>
          <br>
        </div>
        <div class="recruitment-sidebar fl">
          <ul>
            <li class="qq">QQ群：62394002</li>
            <li class="tel">(+86)18565886565</li>
            <li class="weixin">请用手机扫描：</li>
            <li class="weixinPic taC"><img src="/img/code.jpg" width="95" height="95"></li>
          </ul>
        </div>
        <p class="clear"></p>
      </div>
    </div>
  </div>
  <!--/mainbody-->

  <script>seajs.use('step')</script>