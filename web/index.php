<?php

// change the following paths if necessary
if (apache_getenv('ENV') == 'debug') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
}
$yii=dirname(__FILE__).'/../lib/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
