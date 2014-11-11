    <div class="sliderOuter" id="sliderOuter">
      <div class="sliderCont posR" id="sliderCont">
        <ul id="sliderItem">
          <a href="http://weibo.com/efeizao" target=_blank><li class="sliderItem0" index="0"></li></a>
          <a href="http://www.efeizao.com/recruitment/step1" style="display:none"><li class="sliderItem1" index="1"></li></a>
          <a href="http://weibo.com/efeizao" target=_blank style="display:none"><li class="sliderItem2" index="2"></li></a>
        </ul>
        <div class="posA sliderPanel" id="sliderPanel" style="left:50%;margin-left:-40px">
          <span class="on" index="0"></span>
          <span index="1"></span>
          <span index="2"></span>
        </div>
      </div>
    </div>
 
  <div id="mainbody_new">
    <div class="mainBig">
      <?php foreach($rooms as $room):?>
      <dl>
        <dt class="new"><a target=_blank href="<?php echo $this->createUrl('/room/index', array('rid' => $room->id));?>"><img src="<?=$room->logo?>" width="345" height="185"><div class="mask"></div><div class="start"></div></a></dt>
        <dd>
          <div class="bigTitle posR"><a target=_blank href="<?php echo $this->createUrl('/room/index', array('rid' => $room->id));?>"><?=$moderators[$room->id]['true_name']?>&nbsp;&nbsp;(<?=$moderators[$room->id]['age']?>/<?=$moderators[$room->id]['height']?>CM/<?=$moderators[$room->id]['weight']?>KG)</a><!--<span class="num"><?=$moderators[$room->id]['weight']?>/<?=$moderators[$room->id]['height']?></span>--></div>
          <p><?=$room->moderator_desc?></p>
        </dd>
      </dl>
      <?php endforeach;?>
      <p class="clear"></p>
    </div>
  </div>

  <script>
  seajs.use('index');
  </script>
