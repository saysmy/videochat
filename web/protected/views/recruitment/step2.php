  <style>
  label.validate-error {margin-left:10px;}
  </style>
  <!--mainbody-->
  <div id="mainbody_new" class="mt20">
    <div class="recruitment wrap">
      <h1>应聘练习生流程</h1>
      <div class="step step2"></div>
      <div class="recruitment-block">
        <div class="recruitment-content fl">
          <h1>练习生的资料：</h1>
          <form id="step2Form">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="mod-fm mt20">
            <tr>
              <th>用户昵称：</th>
              <td><span class="nickname"><?=$user['nickname']?></span></td>
            </tr>
            <tr>
                <th><b>*</b> 真实姓名：</th>
                <td><input type="text" class="fi-txt" name="name" value="<?=$rec->name?>"></td>
            </tr>
            <tr>
                <th><b>*</b> 基本情况：</th>
                <td>年龄 
                  <select name="age" size="1" id="select2">
                    <?php for($i = 18; $i <= 50; $i ++ ):?>
                    <option <?=$i==$rec->age?'selected' : ($i==21?'selected':'')?>><?=$i?></option>
                    <?php endfor?>
                </select>&nbsp;&nbsp;
                身高
                  <select name="height" size="1" id="select2">
                    <?php for($i = 155; $i <= 190; $i ++ ):?>
                    <option value="<?=$i?>" <?=$i==$rec->height?'selected' : ($i==178?'selected':'')?>><?=$i?>cm</option>
                    <?php endfor?>      
                  </select>&nbsp;&nbsp;
                体重
                  <select name="weight" size="1" id="select2">
                    <?php for($i = 40; $i <= 100; $i ++ ):?>
                    <option value="<?=$i?>" <?=$i==$rec->weight?'selected' : ($i==63?'selected':'')?>><?=$i?>kg</option>
                    <?php endfor?>
                  </select>
                </td>
            </tr>
            <tr>
                <th><b>*</b> 身份证号码：</th>
                <td><input type="text" class="fi-txt" name="id_card" value="<?=$rec->id_card?>"></td>
            </tr>
            <tr>
                <th><b>*</b> QQ号码：</th>
                <td><input type="text" class="fi-txt" name="qq" value="<?=$rec->qq?>"></td>
            </tr>
            <tr>
                <th><b>*</b> 邮 箱：</th>
                <td><input class="fi-txt" name="email" value="<?=$rec->email?>" type="text"></td>
            </tr>
            <tr>
                <th><b>*</b> 手机号码：</th>
                <td><input class="fi-txt" name="mobile" value="<?=$rec->mobile?>" type="text"></td>
            </tr>
            <tr>
                <td colspan="2"><a href="javascript:void(0)"><input type="submit" class="btns btn-1" value="下一步"></a></td>
            </tr>
          </table>
        </form>
          <br>
        </div>
        <div class="recruitment-sidebar fl">
          <ul>
            <li class="qq">QQ群：62394002</li>
            <li class="tel">(+86)18565886565</li>
            <li class="weixin">请用手机扫描：</li>
            <li class="weixinPic taC"><img src="/img/code.jpg" width="95" height="95" id="image"></li>
          </ul>
        </div>
        <p class="clear"></p>
      </div>
    </div>
  </div>
  <!--/mainbody-->

  <script>seajs.use('step');</script>
