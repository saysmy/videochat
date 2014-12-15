<?php
class BanCommand extends CConsoleCommand {
    
    public function actionBan($uid, $rid, $expire = 0) {
    
        Yii::app()->cache->set('ban_' . $rid . '_' . $uid, 'true', $expire);
    }


    public function actionFree($uid, $rid) {
        Yii::app()->cache->delete('ban_' . $rid . '_' . $uid);
    }

}
