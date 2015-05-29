<?php
class ModeratorController extends CController {

    public function actionAdd() {

        $mid = Yii::app()->request->getParam('mid');

        Yii::app()->db->createCommand('begin')->execute();

        $user = User::model()->findByPk($mid);
        if (!$user) {
            return ToolUtils::ajaxOut(100, '主播未找到');
        }

        $user->setScenario('adminModeratorUpdate');
        $user->true_name = trim(Yii::app()->request->getParam('true_name'));
        $user->height = Yii::app()->request->getParam('height');
        $user->age = Yii::app()->request->getParam('age');
        $user->weight = Yii::app()->request->getParam('weight');
        if (!$user->save(true, array('true_name', 'height', 'age', 'weight'))) {
            return ToolUtils::ajaxOut(101, current(current($user->getErrors())));
        }

        $room = Room::model()->find('mid=' . $mid);
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
        $filePath =  'img/roomlogo/' . time() . '_' . $mid . '_upload' . '.' . $file->extensionName;
        $file->saveAs($filePath, true);

        $room = new Room('adminAdd');
        $room->announcement = trim(Yii::app()->request->getParam('announcement'));
        $room->logo = INDEX_URL . $filePath;
        $room->description = trim(Yii::app()->request->getParam('description'));
        $room->mid = $mid;
        $room->moderator_desc = trim(Yii::app()->request->getParam('moderator_desc'));
        $room->rank = Yii::app()->request->getParam('rank');
        if (!$room->save()) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(103, $room->getSingleErrorMsg());
        }

        $moderatorAddition = new ModeratorAddition;
        $moderatorAddition->mid = $mid;
        $moderatorAddition->qq = trim(Yii::app()->request->getParam('qq'));
        $moderatorAddition->mobile = trim(Yii::app()->request->getParam('mobile'));
        $moderatorAddition->salary_per_hour = Yii::app()->request->getParam('salary_per_hour');
        $moderatorAddition->alipay_account = trim(Yii::app()->request->getParam('alipay_account'));
        $moderatorAddition->sociaty_id = Yii::app()->request->getParam('sociaty_id');
        $moderatorAddition->add_time = date('Y-m-d H:i:s');
        if (!$moderatorAddition->save()) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(105, $moderatorAddition->getSingleErrorMsg());
        }

        Yii::app()->db->createCommand('commit')->execute();

        ToolUtils::ajaxOut(0);
    }

    public function actionGetInfo($mid) {
        $user = User::model()->findByPk($mid);
        if (!$user) {
            return ToolUtils::ajaxOut(200, '主播未找到');
        }

        ToolUtils::ajaxOut(0, '', $user->getAttributes());
    }

    public function actionGetModerators($page, $rows, $mid = null) {
        $rooms = Room::model()->findAll(array(
                'condition' => 'status != ' . ROOM_STATUS_INVALID . ($mid ? ' and mid=' . $mid : ''),
                'offset' => ($page - 1) * $rows,
                'limit' => $rows,
            )
        );

        $total = Room::model()->count('status != ' . ROOM_STATUS_INVALID . ($mid ? ' and mid=' . $mid : ''));

        $data = array();
        foreach($rooms as $room) {
            $i = $room->getAttributes();
            if (!$room->moderator) {
                continue;
            }

            $i['nickname'] = $room->moderator->nickname;
            $i['height'] = $room->moderator->height;
            $i['age'] = $room->moderator->age;
            $i['weight'] = $room->moderator->weight;
            $i['true_name'] = $room->moderator->true_name;

            $moderatorAddition = $room->getModeratorAddition();
            if ($moderatorAddition) {
                $i['qq'] = $moderatorAddition->qq;
                $i['mobile'] = $moderatorAddition->mobile;
                $i['alipay_account'] = $moderatorAddition->alipay_account;
                $i['sociaty_id'] = $moderatorAddition->sociaty_id;
                $i['salary_per_hour'] = $moderatorAddition->salary_per_hour;
            }
            $data[] = $i;
        }

        echo json_encode(array('total' => $total, 'rows' => $data));

    }

    public function actionModify() {
        $rid = Yii::app()->request->getParam('rid');
        $room = Room::model()->findByPk($rid);
        if (!$room) {
            return ToolUtils::ajaxOut(300, '房间不存在');
        }
        $mid = $room->mid;

        Yii::app()->db->createCommand('begin')->execute();

        $file = CUploadedFile::getInstanceByName('logo');
        if ($file) {
            $fileContent = file_get_contents($file->tempName);
            $filePath =  'img/roomlogo/' . time() . '_' . $mid . '_upload' . '.' . $file->extensionName;
            $file->saveAs($filePath, true);

            $room->logo = INDEX_URL . $filePath;
        }

        $room->setScenario('adminUpdate');
        $room->moderator_desc = trim(Yii::app()->request->getParam('moderator_desc'));
        $room->announcement = trim(Yii::app()->request->getParam('announcement'));
        $room->rank = Yii::app()->request->getParam('rank');
        if (!$room->save(true, array('logo', 'moderator_desc', 'announcement', 'rank'))) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(301, $room->getSingleErrorMsg());
        }

        $user = User::model()->findByPk($mid);
        if (!$user) {
             Yii::app()->db->createCommand('rollback')->execute();
             return ToolUtils::ajaxOut(302, '主播不存在');      
        }

        $user->setScenario('adminModeratorUpdate2');
        $user->nickname = trim(Yii::app()->request->getParam('nickname'));
        $user->true_name = trim(Yii::app()->request->getParam('true_name'));
        $user->age = Yii::app()->request->getParam('age');
        $user->weight = Yii::app()->request->getParam('weight');
        $user->height = Yii::app()->request->getParam('height');
        if (!$user->save(true, array('nickname', 'true_name', 'height', 'weight', 'age'))) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(303, $room->getSingleErrorMsg());
        }

        $moderatorAddition = ModeratorAddition::model()->find('mid=' . $mid);
        if (!$moderatorAddition) {
            $moderatorAddition = new ModeratorAddition('adminAdd');
            $moderatorAddition->mid = $mid;
            $moderatorAddition->qq = trim(Yii::app()->request->getParam('qq'));
            $moderatorAddition->mobile = trim(Yii::app()->request->getParam('mobile'));
            $moderatorAddition->alipay_account = trim(Yii::app()->request->getParam('alipay_account'));
            $moderatorAddition->salary_per_hour = Yii::app()->request->getParam('salary_per_hour');
            $moderatorAddition->sociaty_id = Yii::app()->request->getParam('sociaty_id');
            $moderatorAddition->add_time = date('Y-m-d H:i:s');
        }
        else {
            $moderatorAddition->setScenario('adminUpdate');
            $moderatorAddition->qq = trim(Yii::app()->request->getParam('qq'));
            $moderatorAddition->mobile = trim(Yii::app()->request->getParam('mobile'));
            $moderatorAddition->alipay_account = trim(Yii::app()->request->getParam('alipay_account'));
            $moderatorAddition->salary_per_hour = Yii::app()->request->getParam('salary_per_hour');
            $moderatorAddition->sociaty_id = Yii::app()->request->getParam('sociaty_id');
        }
        if (!$moderatorAddition->save()) {
            Yii::app()->db->createCommand('rollback')->execute();
            return ToolUtils::ajaxOut(304, $moderatorAddition->getSingleErrorMsg());            
        }

        Yii::app()->db->createCommand('commit')->execute();

        ToolUtils::ajaxOut(0);
    }


}




