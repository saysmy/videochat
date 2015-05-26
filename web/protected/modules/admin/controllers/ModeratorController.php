<?php
class ModeratorController extends CController {

    public function actionAdd() {
        $nickname = trim(Yii::app()->request->getParam('nickname'));
        $user = User::model()->find('nickname=:nickname', array(':nickname' => $nickname));
        if (!$user) {
            return ToolUtils::ajaxOut(100, '用户不存在');
        }

        Yii::app()->db->createCommand('begin')->execute();

        $user->setScenario('adminModeratorUpdate');
        $user->true_name = Yii::app()->request->getParam('true_name');
        $user->height = Yii::app()->request->getParam('height');
        $user->age = Yii::app()->request->getParam('age');
        $user->weight = Yii::app()->request->getParam('weight');
        if (!$user->save(true, array('true_name', 'height', 'age', 'weight'))) {
            return ToolUtils::ajaxOut(101, current(current($user->getErrors())));
        }

        $room = Room::model()->find('mid=' . $user->id);
        if ($room) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(104, '该用户已经是主播了');
        }

        $file = CUploadedFile::getInstanceByName('logo');
        if (!$file) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(102, 'logo文件获取失败');
        }
        $fileContent = file_get_contents($file->tempName);
        $filePath =  './img/roomlogo/' . time() . '_' . $user->id . '_upload' . '.' . $file->extensionName;
        $file->saveAs($filePath, true);

        $room = new Room('adminAdd');
        $room->announcement = trim(Yii::app()->request->getParam('announcement'));
        $room->logo = $filePath;
        $room->description = trim(Yii::app()->request->getParam('description'));
        $room->mid = $user->id;
        $room->moderator_desc = trim(Yii::app()->request->getParam('moderator_desc'));
        $room->rank = trim(Yii::app()->request->getParam('rank'));
        if (!$room->save()) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(103, $room->getSingleErrorMsg());
        }

        $moderatorAddition = new ModeratorAddition;
        $moderatorAddition->mid = $user->id;
        $moderatorAddition->qq = Yii::app()->request->getParam('qq');
        $moderatorAddition->mobile = Yii::app()->request->getParam('mobile');
        $moderatorAddition->salary_per_hour = Yii::app()->request->getParam('salary_per_hour');
        $moderatorAddition->add_time = date('Y-m-d H:i:s');
        if (!$moderatorAddition->save()) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(105, $moderatorAddition->getSingleErrorMsg());
        }

        Yii::app()->db->createCommand('commit')->execute();

        ToolUtils::ajaxOut(0);
    }

}