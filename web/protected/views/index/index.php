    <script type='text/javascript' src='/js/ckplayer.js'></script>
    <!--slider start-->
    <div class="sliderOuter" id="sliderOuter">
      <div class="sliderCont posR" id="sliderCont">
        <ul id="sliderItem">
        <?php foreach($liveRooms as $k => $room):?>
          <li class="sliderItem" style="<?=$k != 0 ? 'display:none;' : ''?>height:382px;background:url(<?=$room['banner']?>) center 0 no-repeat;" play-start-time="<?=$room["play_start_time"]?>" play-end-time="<?=$room["play_end_time"]?>" video-url="<?=$room["video_url"]?>" room="<?=$this->createUrl('/room/index', array('rid' => $room['id']))?>" detail-url="<?=$room['detail_url']?>">
            <div class="sliderWrap">
              <a href="javascript:void(0)" class="btn-start" target=_blank></a>
              <div class="sliderInfo posA">
                <h1><?=$room['moderator']['true_name']?> <i><?=$room['moderator']['age']?>/<?=$room['moderator']['height']?>/<?=$room['moderator']['weight']?></i></h1>
                <p><?=$room['moderator_desc']?></p>
                <span><a href="javascript:void(0)" class="love <?=in_array($room['id'], $loveRooms) ? 'liked' : 'like'?>" rid="<?=$room['id']?>"><?=$room['love_num']?></a><a href="<?=$room['detail_url'] ? $room['detail_url'] : 'javascript:void(0)'?>" class="star" target=_blank></a></span>
              </div>
              <div class="sliderTime posA">
                <div class="timeInner posR">
                  <div class="timeLive" style="display:none;"><a href="<?=$this->createUrl('/room/index', array('rid' => $room['id']))?>" target=_blank></a></div>
                  <div class="timeCont" style="display:block;">
                  <dl class="days">
                    <dt>-</dt>
                    <dd>-</dd>
                  </dl>
                  <dl class="hours">
                    <dt>-</dt>
                    <dd>-</dd>
                  </dl>
                  <dl class="mins">
                    <dt>-</dt>
                    <dd>-</dd>
                  </dl>
                  </div>
                  <span><?=$room['moderator']['true_name']?> <i>练习生的直播倒计时</i></span>
                  <a href="javascript:void(0)" class="sliderReg">立即注册，和他一起肉身互动</a>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach?>
        </ul>
        <div class="sliderPanel posA" id="sliderPanel" style="left:50%;margin-left:-200px">
          <span class="sliderLeft"></span>
          <span class="sliderRight"></span>
          <div class="sliderSmall">
            <ul>
              <?php foreach($liveRooms as $k => $room):?>
              <li class="<?=$k == 0 ? 'on' : ''?>"><a href="javascript:void(0)"><img src="<?=$room['logo']?>" width="85" height="50"></a></li>
              <?php endforeach?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!--/slider end-->
 
  <div id="mainbody_new">
    <div class="mainBig">
      <?php foreach($rooms as $room):?>
      <dl>
        <dt class="new"><a target=_blank href="<?php echo $this->createUrl('/room/index', array('rid' => $room->id));?>"><img src="<?=$room->logo?>" width="345" height="185"><div class="mask"></div><div class="start"></div></a></dt>
        <dd>
          <div class="bigTitle posR"><a class="title" target=_blank href="<?php echo $this->createUrl('/room/index', array('rid' => $room->id));?>"><?=$room->moderator['true_name']?>&nbsp;&nbsp;(<?=$room->moderator['age']?>/<?=$room->moderator['height']?>CM/<?=$room->moderator['weight']?>KG)</a><a href="javascript:void(0)" class="love <?=in_array($room['id'], $loveRooms) ? 'liked' : 'like'?>" rid="<?=$room->id?>"><?=$room->love_num?></a><a href="<?=$room['detail_url']?>" class="star" target=_blank></a></div>
          <p><?=$room->moderator_desc?></p>
        </dd>
      </dl>
      <?php endforeach;?>
      <p class="clear"></p>
    </div>
  </div>

  <script>

  $(".mainBig > dl:nth-child(3n)").css({"margin-right":"0"});

  seajs.use('index', function(index) {
      index.showActivity();
      index.slide(<?=count($liveRooms)?>);
      index.startTimer(<?=time()?>);
  });

  </script>
