<?php
    define('DOMAIN', 'www.feizao001.com');
    define('DEFAULT_HEAD_PIC', 'http://www.feizao001.com/img/default.jpg');
    define('ALIPAY_LIB_PATH', dirname(__FILE__) . '/../../../lib/alipay/');
    define('ALIPAY_RETURN_URL', 'http://www.feizao001.com/recharge/alipayReturn');
    define('ALIPAY_NOTIRY_URL', 'http://www.feizao001.com/recharge/alipayNotify');
    define('ALIPAY_ACCOUNT', 'pay@7po.com');
    define('ALIPAY_PARTNER', '2088901945336871');
    define('ALIPAY_KEY', 'xw0z7xr4ab0jmf72u04xdxo1jifpxj6q');
    define('ALIPAY_CERT', ALIPAY_LIB_PATH . 'cacert.pem');
    define('RECHARGE_SHOW_URL', 'http://www.feizao001.com/recharge/show');
    
    define('COMMON_USER', 1);
    define('MODERATOR_USER', 2);
    define('ADMIN_USER', 3);
    define('DEAD_USER', 4);

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