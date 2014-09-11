<?php

//curl -d 'cat_id=0' http://www.qzone.cc/name/refreshname

include(dirname(__FILE__) . '/../../../lib/simple_html_dom.php');

class InitDeadUserCommand extends CConsoleCommand
{
    private $users = array();

    public function run() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.qzone.cc/name/refreshname');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'cat_id=0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = json_decode(curl_exec($ch), true);
        if ($json) {
            $name = array();
            $html = $json['html'];
            $dom = str_get_html($html);
            foreach($dom->find('.feed_list .txt_name') as $item) {
                $names[] = trim($item->plaintext);
            }
            foreach($names as $name) {
                $user = new User();
                $user->username = $name;
                $user->password = '';
                $user->age = rand(18, 30);
                $user->height = rand(155, 190);
                $user->weight = rand(50, 90);
                $user->nickname = $name;
                $user->sex = rand(1, 2);
                $user->head_pic_1 = DEFAULT_HEAD_PIC;
                $user->email = '';
                $user->mobile = '';
                $user->qq_openid = '';
                $user->qq_accesstoken = '';
                $user->qq_accessexpire = 0;
                $user->source = SOURCE_FROM_SELF;
                $user->email_validated = 0;
                $user->mobile_validated = 0;
                $user->type = DEAD_USER;
                $user->dead_user_status = DEAD_USER_FREE;
                $user->coin = 0;
                $user->last_login_time = Date('Y-m-d H:i:s', time(0));
                $user->register_time = Date('Y-m-d H:i:s');
                $user->save();
            }
        }
    }

}
