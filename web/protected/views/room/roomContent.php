  <script>
  var app = {rid : <?=$rid?>, sid : "<?=$sid?>", uid : <?=$uid?>, appname : "<?=$appname?>", sip : "<?=$sip?>", mid : <?=$mid?>}
  var prop = <?php echo json_encode($prop);?>
  </script>
  <div id="roombody" class="mt10">
    <div class="wrap">
      <!--roomLeft-->
      <div class="roomLeft fl">
        <div class="roomPlayer"><div id="roomPlayer"></div></div>
        <div class="roomNotice"><a href="#">99情歌（70920）</a> 送个 <a href="#">只为你停留（88989）</a><b>1个</b>我的好兄弟（06.26 10：56）</div>
        <div class="roomGifts mt10" id="giftMsgPanel">
          <ul>
          </ul>
        </div>
        <div class="roomAct posR mt10">
          <dl class="gifts fl">
            <dt><img src="img/i31.gif" id="choosePropImg" width=42 height=42 /></dt>
            <dd><span id="chooseProp">挑选礼物</span></dd>
          </dl>
          <ul>
            <li>数量</li>
            <li class="giftsNum"><span style="width:60px;"><i id="propNum">1</i><em></em></span></li>
            <li>给</li>
            <li class="giftsName"><span style="width:110px;"><i id="propTo" to='<?=$mid?>'>主播</i><em></em></span></li>
            <li class="giftsBtns"><a href="javascript:sendGift()" class="btns btn-a">赠送</a> <a href="#" class="btns btn-b">充值</a></li>
          </ul>
          <p class="clear"></p>
        </div>
      </div>
      <!--/roomLeft-->
      <!--/weekStar-->
      <!--roomMid-->
      <div class="roomMid fl">
        <div class="roomTab" id="roomTab">
          <a href="#" class="room on">聊天大厅</a> <span>|</span> <a href="#" class="mic">麦序</a> <span>|</span> <a href="#" class="ucenter">个人中心</a>
          <p class="clear"></p>
        </div>
        <div class="roomItem mt10" id="roomItem0" style="display:block;">
          <div class="roomPub">【房间公告】<?=$this->room->announcement?></div>
          <div class="roomContent">
            <div class="roomChat posR" style="height:320px;" id="publicChatPanel">
              <table width="323" cellpadding="0" cellspacing="0" border="0">
                <tr>
                </tr>
              </table>
            </div>
            <div class="roomPannel"><a href="#" id="panelArrow" class="arrow_up"></a></div>
            <div class="roomChat2" style="height:85px;" id="privateChatPanel">
              <span style="color:#f00;">【公告】TopStage正式上线欢迎各位名媛</span>
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
              &nbsp;&nbsp;<a href="#" id="face"><img src="img/face/e8.png" width="24" height="24"></a>
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
        <div class="roomUserTab" id="roomUserTab"><a href="#" class="on">管理员(<span id="c_0">0</span>)</a><a href="#">观众(<span id="c_1">0</span>)</a></div>
        <div class="roomUserItem" id="roomUserItem0" style="display:block;">
          <ul>
          </ul>
        </div>
        <div class="roomUserItem" id="roomUserItem1">
          <ul>

          </ul>
        </div>
      </div>
      <!--/roomRight-->
      <p class="clear"></p>
    </div>
  </div>