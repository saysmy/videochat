<?php
class DBInitCommand extends CConsoleCommand
{
	private $roomData = array(
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/6.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),		
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/6_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/7_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/8_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/9_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/10_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/6_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/7_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/8_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/9_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/10_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/6.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/11_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/12_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/13_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/14_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/15_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
		array('announcement' => '聊天室公告', 'logo' => 'http://www.eccbuy.net/img/15_s1.jpg', 'description' => '聊天室简介', 'max_user' => 100, 'mid' => 1, 'moderator_sign' => '主播感言', 'score' => 0),
	);
	public function run($argv) {
		switch($argv[0])
		{
			case 'room':
				$this->initRoom();
				break;
			default:

		}
	}

	private function initRoom() {
		echo "init room\n";
		foreach($this->roomData as $item) {
			$room = new Room;
			foreach($item as $k => $v) {
				$room->$k = $v;
			}
			$room->save();
		}
	}
}
