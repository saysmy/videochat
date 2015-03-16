      <div class="pageContent">
        <div class="userInfo mar">
          <dl>
            <dt>您的账户余额：<b><?=$userInfo['coin']?></b>泡泡</dt>
            <dd><a href="/recharge/center" class="btns btn-1">立即充值</a></dd>
            <p class="clear"></p>
          </dl>
        </div>
        <div class="userConsume mar">
          <h1>您的消费明细：</h1>
          <div class="userTab" id="userTab"><a href="/userCenter/giftEarn">收到的礼物</a><a href="/userCenter/giftConsume" class="on">送出的礼物</a></div>
          <div class="userItem mt10" id="userItem0">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <th>接收人</th>
                <th>消费时间</th>
                <th>物品</th>
                <th>数量</th>
                <th>支付泡泡</th>
              </tr>
            <?php if(!$userInfo['consume']):?>
              <tr>
                <td colspan="5"><div class="userConsumeNull">暂时没有记录！</div></td>
              </tr>
              <?php else:?>
              <?php foreach($userInfo['consume'] as $i):?>
              <tr>
                  <td><b><?=$receivers[$i->mid]?></b></td>
                  <td><?=$i['time']?></td>
                  <td><?=$i->property['name']?></td>
                  <td><?=$i['pnum']?></td>
                  <td><?=$i['cost']?></td>
              </tr>
              <?php endforeach?>
            <?php endif?>
            </table>
<?php
 $this->widget('CLinkPager',array(
        'pages' => new CPagination($userInfo['consume_total']), 
        'pageSize' => 10,
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'nextPageLabel' => '>',
        'prevPageLabel' => '<',
        'selectedPageCssClass' => 'on',
        'header' => '',
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



