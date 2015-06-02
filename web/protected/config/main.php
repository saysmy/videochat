<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
include dirname(__FILE__) . '/define.php';

global $seaFiles;

$seaFiles = array(
      'layer' => 'layer/layer.min.js',
      'plupload' => 'plupload/plupload.full.min.js',
      'jcrop'    => 'jquery.Jcrop.min.js',
      'validate' => 'jquery.validate.min.js?v=20150327',
      'registerLogin' => 'registerLogin.js?v=20141116',
      'step'     => 'step.js?v=20141116',
      'user'     => 'user.js?v=20141022',
      'room'	 => 'room.js?v=2015060102',
      'popCheckbox' => 'popCheckbox.js?v=20141215',
      'index'    => 'index.js?v=20150602',
      'head'     => 'head.js?v=20141215',
      'common'   => 'common.js?v=20141215',
      'password' => 'password.js?v=20150508',
      'cookie'   => 'jquery.cookies.js',
      'poshytip' => 'poshytip/jquery.poshytip.min.js'
);

global $env;
global $fmsServer;
$fmsServer = include dirname(__FILE__) . '/fmsServer.' . $env . '.php';

global $jsDefine;
$jsDefine = include dirname(__FILE__) . '/jsDefine.php';

session_set_cookie_params(SESSION_COOKIE_EXPIRE_TIME);
ini_set('session.gc_maxlifetime', SESSION_EXPIRE_TIME);
session_save_path(dirname(__FILE__).'/../sessions');

return array(
	'id' => 'videochat',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'肥皂网-宽容似海，不提伤害',

	'defaultController' => 'index',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.widgets.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii' => array(
			'class'=>'system.gii.GiiModule',
			'password'=>'letmego',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

        'app',

        'admin' => array(
            'defaultController' => 'index',
        ),

    ),

	// application components
	'components'=>array(
		'cache' => array(
			'class' => 'system.caching.CMemCache',
			'servers' => array(
				array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),
			),
		),
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=chat',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'letmego',
			'charset' => 'utf8',
		),

		'urlManager'=>array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'http://admin.' . MAIN_DOMAIN . '<p:.*>' => '/admin<p>',
                'http://www.' . MAIN_DOMAIN . '/admin*' => '/error/error',
            	'room/<rid:\d+>' => 'room/index',
            ),
        ),
		
		'errorHandler'=>array(
			'errorAction'=>'error/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info',
				),
			),
		),

//       'clientScript' => array(
//           'scriptMap' => array(
//           	'jquery.js' => false,
//           	'jquery.min.js' => false,
//           ),
//       ),		
	),

	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'cookieExpire' => '86400',
		'fmsServer' => $fmsServer['server'][rand() % count($fmsServer['server'])]['ip'],
		'unLoginUid' => -1,
	),
);
