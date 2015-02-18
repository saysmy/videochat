<?php
    define('WEB_ROOT', realpath(dirname(__FILE__) . '/../../') . '/');
    define('CONFIG_DIR', dirname(__FILE__) . '/');
    define('DOMAIN', 'www.efeizao.com');
    define('MAIN_DOMAIN', 'efeizao.com');
    define('DEFAULT_HEAD_PIC', 'http://www.efeizao.com/img/default.jpg');
    define('ALIPAY_LIB_PATH', dirname(__FILE__) . '/../../../lib/alipay/');
    define('ALIPAY_RETURN_URL', 'http://www.efeizao.com/recharge/alipayReturn');
    define('ALIPAY_NOTIRY_URL', 'http://www.efeizao.com/recharge/alipayNotify');
    if (YII_DEBUG) {
        define('ALIPAY_ACCOUNT', 'jttx2014@126.com');
        define('ALIPAY_PARTNER', '2088411193896275');
        define('ALIPAY_KEY', 'min7caght3i5qc286rljsmblfi1yt9mp');
    }
    else {
        define('ALIPAY_ACCOUNT', 'account@efeizao.com');
        define('ALIPAY_PARTNER', '2088611281054040');
        define('ALIPAY_KEY', 'zyig1sggrifuu2zvurxi38abko9zkkce');
    }
    define('ALIPAY_CERT', ALIPAY_LIB_PATH . 'cacert.pem');
    define('RECHARGE_SHOW_URL', 'http://www.efeizao.com/recharge/show');
    
    define('UNLOGIN_USER', -1);
    define('COMMON_USER', 1);
    define('MODERATOR_USER', 2);
    define('ADMIN_USER', 3);
    define('DEAD_USER', 4);
    define('ROOM_OWN_USER', 5);

    define('DEAD_USER_FREE', 0);
    define('DEAD_USER_IN_USE', 1);

    define('SOURCE_FROM_SELF', 1);
    define('SOURCE_FROM_QQ', 2);

    define('QQ_LOGIN_PRE', 'QQLogin_');

    define('PAY_TYPE_ALI', 1);
    define('PAY_NUMBER_BASE', 1000000000);
    define('RECHARGE_INIT', 0);
    define('RECHARGE_COMPLETE', 1);

    define('PROP_SHOW_MIN_PRICE', 50);

    define('MEDIA_SITE_DOMAIN', 'www.eestarmedia.com');

    define('NEW_USER_COIN', 5);

    define('NOT_LOGIN_ERR', -100);

    define('SYNC_START_COOKIE_KEY', 'getUserInfoStart');
    define('SYNC_USERINFO_RECHARGE_TYPE', 1);

    define('ROOM_PUB_NOBODY_UID', -1);
    define('ROOM_PUB_DEFAULT_DATE', '1970-01-01 08:00:00');
    define('DEFAULT_DATE', '1970-01-01 08:00:00');

    define('COMMON_LEVEL_USER', 0);
    define('VIP_LEVEL_USER', 1);

    define('COMMON_ROOM', 0);//普通房间
    define('MULTI_MODERATOR_ROOM', 1);//多主播房间

    define('VIP_MONTH_PRICE', 29.9);




