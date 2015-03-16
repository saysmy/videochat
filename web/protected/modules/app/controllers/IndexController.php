<?php
class IndexController extends CController {

    public function actionFocusActivity() {
        $rooms = Room::model()->findAll(array('condition' => 'status=1', 'order' => 'rank desc'));
        $data = array();
        foreach($rooms as $room) {
            $data[] = array(
                'type' => INDEX_FOCUS_ROOM_TYPE,
                'rid' => (int)$room->id,
                'pic' => strpos($room->logo, 'http') !== 0 ? 'http://' . DOMAIN . $room->logo : $room->logo,
            );
        }

        ToolUtils::ajaxOut(0, '', $data);
    }

    public function actionRecommendedRooms() {
        $rooms = Room::model()->findAll(array('condition' => 'status != -1', 'order' => 'rank desc'));
        $data = array();
        foreach($rooms as $room) {
            $data[] = array(
                'id' => (int)$room->id,
                'logo' => $room->logo,
                'love' => (int)$room->love_num,
                'moderator_desc' => $room->moderator_desc,
                'isPlaying' => CRoom::isPlaying($room->id),
                'moderator' => array(
                    'height' => (int)$room->moderator->height,
                    'weight' => (int)$room->moderator->weight,
                    'age'    => (int)$room->moderator->age,
                    'true_name' => $room->moderator->true_name,
                ),
            );
        }

        ToolUtils::ajaxOut(0, '', $data);
    }
}