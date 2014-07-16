  <!--mainbody-->
  <div id="mainbody">
    <div class="wrap">
      <div class="topad posR">
        <div class="topbanner posA"><img src="img/2_s1.jpg" width="770" height="160"></div>
        <div class="topstar posA"></div>
      </div>
      <!--mcontent-->
      <div class="mcontent">
        <div class="content fl">
          <!--blockA-->
          <div class="blockA">
            <dl>
              <?php $room = array_shift($roomData['category0'])?>
              <dt> 
                <a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="380" height="290"></a> 
                <div class="vtitle posA"><a href="#">爱的感言：<?=$room->moderator_sign?></a></div>
                <div class="vinfo posA">
                  <span class="view">458</span>
                  <span class="time">120分钟</span>
                  <span class="click">174/70</span>
                </div>
                <div class="mask mask vmask posA"></div>
              </dt>
              <dd>
                <ul class="vlist">
                <?php foreach($roomData['category0'] as $room):?>
                  <li>
                    <a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="185" height="140"></a>
                    <div class="vinfo posA">
                      <span class="view">458</span>
                      <span class="time">120分钟</span>
                      <span class="click">174/70</span>
                    </div>
                    <div class="mask mask vmask2 posA"></div>
                  </li>
                <?php endforeach;?>
                  <p class="clear"></p>
                </ul>
              </dd>
              <p class="clear"></p>
            </dl>
          </div>
          <!--/blockA-->
          <!--blockB-->
          <div class="blockB mt10">
            <h1 class="t1"><span>鲜肉少年</span><a href="#" class="more">更多&gt;&gt;</a></h1>
            <div class="vlist2 mt10">
            <?php foreach($roomData['category1'] as $room):?>
              <dl>
                <dt><a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="180" height="135"></a></dt>
                <dd>
                  <div class="vtitle2"><a href="#">爱的感言：<?=$room->moderator_sign?></a></div>
                  <div class="vinfo2 posR">
                    <span class="view">458</span>
                    <span class="time">120分钟</span>
                    <span class="click">174/70</span>
                  </div>
                </dd>
              </dl>
            <?php endforeach;?>
              <p class="clear"></p>
            </div>
          </div>
          <!--/blockB-->
          <!--blockC-->
          <div class="blockC mt10">
            <h1 class="t1"><span>鲜肉少年</span><a href="#" class="more">更多&gt;&gt;</a></h1>
            <div class="vlist2 mt10">
            <?php foreach($roomData['category2'] as $room):?>
              <dl>
                <dt><a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="180" height="135"></a></dt>
                <dd>
                  <div class="vtitle2"><a href="#">爱的感言：<?=$room->moderator_sign?></a></div>
                  <div class="vinfo2 posR">
                    <span class="view">458</span>
                    <span class="time">120分钟</span>
                    <span class="click">174/70</span>
                  </div>
                </dd>
              </dl>
            <?php endforeach;?>
              <p class="clear"></p>
            </div>
          </div>
          <!--/blockC-->
          <!--blockD-->
          <div class="blockD mt10">
            <div class="roomBox fl">
              <h2 class="r1">推荐房间</h2>
              <div class="roomTop">
                <?php $room = array_shift($roomData['recommend']);?>
                <dl>
                  <dt><a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="175" height="100"></a></dt>
                  <dd>
                    <h3><a href="#"><?=$room->name?></a></h3>
                    <span class="roomid">房间号：<?=$room->id?></span>
                    <span class="roomnum">房间人数：458人</span>
                    <a href="#" class="follow">+关注</a>
                  </dd>
                </dl>
                <div class="roomTxt">【简介】：<?=$room->description?></div>
              </div>
              <div class="roomList">
              <?php foreach($roomData['recommend'] as $room):?>
                <dl>
                  <dt><a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="130" height="75"></a></dt>
                  <dd>
                    <h3><a href="#">房间名称：<?=$room->name?></a></h3>
                    <span class="roomid">房间号：<?=$room->id?></span>
                    <span class="roomnum">房间人数：458人 &nbsp;&nbsp;<a href="#" class="follow">+关注</a></span>
                  </dd>
                </dl>
              <?php endforeach;?>
              </div>
            </div>
            <div class="roomBox fl ml10">
              <h2 class="r2">热门房间<a href="#">申请房间&gt;&gt;</a></h2>
              <div class="roomTop">
                <?php $room = array_shift($roomData['hot']);?>
                <dl>
                  <dt><a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="175" height="100"></a></dt>
                  <dd>
                    <h3><a href="#"><?=$room->name?></a></h3>
                    <span class="roomid">房间号：<?=$room->id?></span>
                    <span class="roomnum">房间人数：458人</span>
                    <a href="#" class="follow">+关注</a>
                  </dd>
                </dl>
                <div class="roomTxt">【简介】：<?=$room->description?></div>
              </div>
              <div class="roomList">
              <?php foreach($roomData['hot'] as $room):?>
                <dl>
                  <dt><a href="?r=room&rid=<?=$room->id?>"><img src="<?=$room->logo?>" width="130" height="75"></a></dt>
                  <dd>
                    <h3><a href="#">房间名称：<?=$room->name?></a></h3>
                    <span class="roomid">房间号：<?=$room->id?></span>
                    <span class="roomnum">房间人数：458人 &nbsp;&nbsp;<a href="#" class="follow">+关注</a></span>
                  </dd>
                </dl>
              <?php endforeach;?>
              </div>
            </div>
            <p class="clear"></p>
          </div>
          <!--/blockD-->
        </div>
        <!--/content-->
        <div class="sidebar fl ml20">
          <?php if($uInfo && $uInfo['type'] == 2):?>
          <div class="live"><a href="index.php?r=room&rid=<?=$uInfo['rid']?>" class="btns btn-live"></a></div>
          <?php endif;?>
          <div class="mNews mt10">
            <h4>网站公告</h4>
            <div class="mNewsList">
              <a href="#">热烈庆祝TMD、倾城直播三周年热烈庆祝TMD、倾城直播三周年</a>
              <a href="#">热烈庆祝TMD、倾城直播三周年</a>
              <a href="#">热烈庆祝TMD、倾城直播三周年</a>
              <a href="#">热烈庆祝TMD、倾城直播三周年</a>
              <a href="#">热烈庆祝TMD、倾城直播三周年</a>
              <a href="#">热烈庆祝TMD、倾城直播三周年</a>
              <a href="#" class="more">更多&gt;&gt;</a>
            </div>
          </div>
          <!--/mNews-->
          <div class="weekStar mt10">
            <h4>一周星主播<b>TOP</b></h4>
            <div class="weekStarRank mt10">
              <div class="weekStarTop posR"> 
                <a href="#"><img src="img/6.jpg" width="185" height="140"></a>
                <dl class="top1"><dt>1</dt><dd>爱的小鲜肉~</dd></dl>
                <div class="mask vmask2 posA"></div>
              </div>
              <div class="weekStarList mt10">
                <dl>
                  <dt><a href="#"><img src="img/16_s1.jpg" width="68" height="56"></a><em>2</em></dt>
                  <dd>
                    <a href="#">曼妮猫oooo</a>
                    <span>人气：<b>1231534</b>人</span>
                  </dd>
                </dl>
                <dl>
                  <dt><a href="#"><img src="img/16_s1.jpg" width="68" height="56"></a><em>3</em></dt>
                  <dd>
                    <a href="#">曼妮猫oooo</a>
                    <span>人气：<b>1231534</b>人</span>
                  </dd>
                </dl>
                <dl>
                  <dt><a href="#"><img src="img/16_s1.jpg" width="68" height="56"></a><em>24</em></dt>
                  <dd>
                    <a href="#">曼妮猫oooo</a>
                    <span>人气：<b>1231534</b>人</span>
                  </dd>
                </dl>
                <dl>
                  <dt><a href="#"><img src="img/16_s1.jpg" width="68" height="56"></a><em>5</em></dt>
                  <dd>
                    <a href="#">曼妮猫oooo</a>
                    <span>人气：<b>1231534</b>人</span>
                  </dd>
                </dl>
                <p class="clear"></p>
              </div>
            </div>
          </div>
          <!--/weekStar-->
          <script>
//tabs
$(document).ready(function(){
  function jq_tabs(str) {
    $("#"+str+"Tab a").mouseover(function(){
      $("#"+str+"Tab a").removeClass("on");
      $(this).addClass("on");
      var key = $("#"+str+"Tab a").index(this);
      $("[id^='"+str+"Item']").hide();
      $("#"+str+"Item"+key).show();
    });
    $("#"+str+"Tab a").eq(0).trigger("mouseover");
  }
  
  jq_tabs("weekPay");
  
});
</script> 
          <div class="weekPay mt10">
            <h4>一周消费榜<b>TOP</b>
              <div class="weekPayTab posA" id="weekPayTab"><a href="#" class="on">日榜</a> | <a href="#">总榜</a></div>
            </h4>
            <div class="weekPayItem" id="weekPayItem0" style="display:block;">
              <dl>
                <dt><a href="#"><img src="img/17_s1.jpg" width="68" height="56"></a></dt>
                <dd><a href="#">曼妮猫oooo</a>
                  <span><img src="css/i17.gif" width="17" height="13"> <img src="css/i18.gif" width="14" height="12"> <img src="css/i19.gif" width="14" height="12"> <img src="css/i20.gif" width="14" height="12"></span>
                  <em></em>
                </dd>
              </dl>
              <ul class="mt10">
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <p class="clear"></p>
              </ul>
            </div>
            <div class="weekPayItem" id="weekPayItem1">
              <dl>
                <dt><a href="#"><img src="img/17_s1.jpg" width="68" height="56"></a></dt>
                <dd><a href="#">2曼妮猫oooo</a>
                  <span><img src="css/i17.gif" width="17" height="13"> <img src="css/i18.gif" width="14" height="12"> <img src="css/i19.gif" width="14" height="12"> <img src="css/i20.gif" width="14" height="12"></span>
                  <em></em>
                </dd>
              </dl>
              <ul class="mt10">
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <li><a href="#">~@曼妮猫ooOOoO</a><span><img src="css/i21.gif" width="14" height="12"> <img src="css/i22.gif" width="20" height="18"></span></li>
                <p class="clear"></p>
              </ul>
            </div>
          </div>
          <!--/weekPay-->
          <div class="roomHot mt10">
            <h4>房间人气榜<b>TOP</b></h4>
            <ul>
              <li><em>1</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>2</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>3</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>4</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>5</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>6</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>7</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>8</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>9</em><a href="#">目的地</a><i>955/1000</i></li>
              <li><em>10</em><a href="#">目的地</a><i>955/1000</i></li>
            </ul>
          </div>
          <!--roomHot-->
          <div class="service mt10">
            <h4>客服中心</h4>
            <div class="hotline">客服热线：400-888888</div>
              <dl><dt>投诉建议：</dt><dd><a href="#">投诉建议</a></dd></dl>
              <dl><dt>我要举报：</dt><dd><a href="#">我要举报</a></dd></dl>
              <dl><dt>销售咨询：</dt><dd><a href="#">销售咨询</a></dd></dl>
              <dl><dt>意见反馈：</dt><dd><a href="#">意见反馈</a></dd></dl>
              <dl><dt>联系客服：</dt><dd><img src="img/btn_qq.jpg" width="83" height="23"></dd></dl>
              <dl><dt>联系客服2：</dt><dd><img src="img/btn_qq.jpg" width="83" height="23"></dd></dl>
          </div>
          <!--service-->
        </div>
        <!--/sidebar-->
        <p class="clear"></p>
      </div>
      <!--/mcontent-->
    </div>
  </div>
  <!--/mainbody-->
