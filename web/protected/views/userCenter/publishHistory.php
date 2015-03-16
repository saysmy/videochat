      <div class="pageContent">
        <div class="userInfo mar">
          <dl>
            <dt>您的账户余额：<b><?=$userInfo['coin']?></b>泡泡</dt>
            <dd><a href="/recharge/center" class="btns btn-1">立即充值</a></dd>
            <p class="clear"></p>
          </dl>
        </div>
        <div class="userConsume mar">
          <h1>您的主播记录：</h1>
          <div class="userItem mt10" id="userItem0">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <th>开播日期</th>
                <th>房间号</th>
                <th>开播时间</th>
                <th>结束时间</th>
                <th>累计时长</th>
              </tr>
            <?php if(!$userInfo['publishHistory']):?>
              <tr>
                <td colspan="5"><div class="userConsumeNull">暂时没有记录！</div></td>
              </tr>
              <?php else:?>
              <?php foreach($userInfo['publishHistory'] as $i):?>
              <tr>
                  <td><b><?=date('Y-m-d', strtotime($i->start_time))?></b></td>
                  <td><?=$i->rid?></td>
                  <td><?=date('H:i:s', strtotime($i->start_time))?></td>
                  <td><?=$i->end_time == ROOM_PUB_DEFAULT_DATE ? '--' : date('H:i:s', strtotime($i->end_time))?></td>
                  <td><?=$i->end_time == ROOM_PUB_DEFAULT_DATE ? '--' : (strtotime($i->end_time) - strtotime($i->start_time))?></td>
              </tr>
              <?php endforeach?>
            <?php endif?>
            </table>
<?php
 $this->widget('CLinkPager',array(
        'pages' => new CPagination($userInfo['total']), 
        'pageSize' => 10,
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'nextPageLabel' => '>',
        'prevPageLabel' => '<',
        'header' => '',
        'selectedPageCssClass' => 'on',
        'cssFile' => false,
    )
 );
?>
          </div>
        </div>
      </div>
<script>
$('.yiiPager a').each(function() {
    $(this).attr('href', $(this).attr('href') + '#mainbody_new')
})
</script>


