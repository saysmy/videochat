  <script>
  var app = {rid : <?=$rid?>, sid : "<?=$sid?>", uid : <?=$uid?>, appname : "<?=$appname?>", sip : "<?=$sip?>", mid : <?=$mid?>}
  var prop = <?php echo json_encode($prop);?>;
  var maxPropInfo = <?php echo json_encode($maxPropInfo);?>;
  </script>
  <div id="roombody" class="mt10">
    <div class="wrap">
      <!--roomLeft-->
      <div class="roomLeft fl">
        <div class="roomPlayer"><div id="roomPlayer"></div></div>
        <div class="roomNotice"></div>
        <div class="roomGifts mt10" id="giftMsgPanel" style="overflow:scroll">
          <ul>
          </ul>
        </div>
        <div class="roomAct posR mt10">
          <dl class="gifts fl">
            <dt><img src="/img/i31.gif" id="choosePropImg" width=42 height=42 /></dt>
            <dd><span id="chooseProp">挑选礼物</span></dd>
          </dl>
          <ul>
            <li>数量</li>
            <li class="giftsNum"><span style="width:60px;"><i><input id="propNum" value=1 style="border:0px;text-align:center;width:40px;padding:0px"></input></i><em></em></span></li>
            <li>&nbsp;给&nbsp;</li>
            <li class=""><span><i id="propTo" to='<?=$mid?>' style="width:110px;overflow:hidden;text-align:center"><?=$this->moderatorUserInfo['nickname']?></i></span></li>
            <li class="giftsBtns"><a href="javascript:void(0)" class="btns btn-a" id="sendGiftBtn">赠送</a><a href="/recharge/center" class="btns btn-b" target="_blank">充值</a></li>
          </ul>
          <p class="clear"></p>
        </div>
      </div>
      <!--/roomLeft-->
      <!--/weekStar-->
      <!--roomMid-->
      <div class="roomMid fl">
        <div class="roomTab" id="roomTab">
          <a href="#" class="room on">聊天大厅</a> <!--<span>|</span> <a href="#" class="mic">麦序</a> <span>|</span> <a href="#" class="ucenter">个人中心</a>-->
          <p class="clear"></p>
        </div>
        <div class="roomItem mt10" id="roomItem0" style="display:block;">
          <div class="roomPub">【房间公告】<?=$this->room->announcement?></div>
          <div class="roomContent">
            <div class="roomChat posR" style="height:320px;" id="publicChatPanel" style="overflow:scroll">
              <table width="323" cellpadding="0" cellspacing="0" border="0">
                <tr>
                </tr>
              </table>
            </div>
            <div class="roomPannel"><a href="#" id="panelArrow" class="arrow_up"></a></div>
            <div class="roomChat2" style="height:85px;" id="privateChatPanel">
              <span style="color:#f00;">【千万情意，唯独为你】肥皂—中国最大的华裔美少年の社区</span>
              <ul>
              </ul>
            </div>
            <div class="roomChatAct">
              对
                <select name="select" size="1" id="msgReceiver">
                  <option value="0">所有人</option>
                  <option value="<?=$mid?>">主播</option>
                </select>
            说：
              <input type="checkbox" id="privateMsg"> 私聊
              &nbsp;&nbsp;<a href="#" id="face"><img src="/img/face/e8.png" width="24" height="24"></a>
              <div style="display:inline-block;position:relative;style:height:25px;width:25px"><a href="javascript:void(0)" id="flower" style=""><img src="/css/i33.jpg" width="25" height="25"></a><div style="height:25px;width:25px;position:absolute;top:0px;cursor:pointer;background-image:url(/css/i33.jpg)" id="flower-loading"></div></div>
            </div>
            <div class="roomChatFm">
              <input type="text" value=" " class="fi-txt" id="msgArea">
              <input type="submit" class="btns btn-c" value="发送" id="sendMsgBtn">
            </div>
          </div>
        </div>
        <div class="roomItem mt10" id="roomItem1">2 No content!</div>
        <div class="roomItem mt10" id="roomItem2">3 No content!</div>
      </div>
      <!--/roomMid-->
      <!--roomRight-->
      <div class="roomRight fl ml10">
        <div class="roomUserTab" id="roomUserTab"><a href="#">管理员(<span id="c_0">0</span>)</a><a href="#" class="on">观众(<span id="c_1">0</span>)</a></div>
        <div class="roomUserItem" id="roomUserItem0">
          <ul>
          </ul>
        </div>
        <div class="roomUserItem" id="roomUserItem1" style="display:block;">
          <ul>

          </ul>
        </div>
      </div>
      <!--/roomRight-->
      <p class="clear"></p>
    </div>
  </div>