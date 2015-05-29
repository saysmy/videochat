<?php

// change the following paths if necessary
$env = 'release';
if (apache_getenv('ENV') == 'dev' || apache_getenv('ENV') == 'beta') {
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    $env = apache_getenv('ENV');
}

$yii=dirname(__FILE__).'/../../PHPLIB/yii-1.1.16/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
