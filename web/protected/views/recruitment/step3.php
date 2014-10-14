  <!--mainbody-->
  <div id="mainbody_new" class="mt20">
    <div class="recruitment wrap">
      <h1>应聘练习生流程</h1>
      <div class="step step3"></div>
      <div class="recruitment-block">
        <div class="recruitment-content fl">
          <h1>上传示例说明：</h1>
          <dl class="upExp">
            <dt>请报名者上传本人<b>素颜正面照</b>若上传艺术照、写真照可能会影响你的报名结果<br><br>请注意照片附件大小在<b>3M以内</b>以免上传时间过长；<br>支持jpg、jpeg、png等格式。</dt>
            <dd></dd>
            <p class="clear"></p>
          </dl>
          <br><br>
          <h1>立即上传照片：</h1>
          <ul class="upList mt20">
            <?php foreach(json_decode($rec->images, true) as $k => $url):?>
              <li<?=$k%4==3?' style="margin-right:0px"':''?> class="list-item"><span class="closeImg">x</span><a><img src="<?=$url?>"></a></li>
            <?php endforeach?>
            <!--<li><span class="closeImg">x</span><a><img src="/img/face225x265.jpg"></a></li>-->
            <li id="addRecPic"></li>
            <p class="clear"></p>
          </ul>
          <div class="mt20"><a href="javascript:void(0)" id="step3Next"><input type="submit" class="btns btn-1" value="确认并提交"></a> &nbsp;&nbsp;<a href="step2"><input type="submit" class="btns btn-2" value="返回修改"></a></div>
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
  <script>seajs.use('step');</script>