    <div class="sliderOuter" id="sliderOuter">
      <div class="sliderCont posR" id="sliderCont">
        <ul id="sliderItem">
          <li class="sliderItem0" index="0"></li>
          <li class="sliderItem1" index="1" style="display:none"></li>
          <li class="sliderItem2" index="2" style="display:none"></li>
        </ul>
        <div style="text-align:center">
        <div class="posA sliderPanel" id="sliderPanel" style="display:inline-block">
          <span class="on" index="0"></span>
          <span index="1"></span>
          <span index="2"></span>
        </div>
        </div>
      </div>
    </div>
 
  <div id="mainbody_new">
    <div class="mainBig">
      <?php foreach($rooms as $room):?>
      <dl>
        <dt class="new"><em></em><a target=_blank href="<?php echo $this->createUrl('/room/index', array('rid' => $room->id));?>"><img src="<?=$room->logo?>" width="345" height="185"><div class="mask"></div><div class="start"></div></a></dt>
        <dd>
          <div class="bigTitle posR"><a target=_blank href="<?php echo $this->createUrl('/room/index', array('rid' => $room->id));?>">爱的感言：<?=$room->announcement?></a><span class="num"><?=$moderators[$room->id]['weight']?>/<?=$moderators[$room->id]['height']?></span></div>
          <p><?=$room->description?></p>
        </dd>
      </dl>
      <?php endforeach;?>
      <p class="clear"></p>
    </div>
  </div>

  <script>
  seajs.use('index');
  </script>
