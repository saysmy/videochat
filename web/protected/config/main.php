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
      'validate' => 'jquery.validate.min.js',
      'registerLogin' => 'registerLogin.js?v=20141116',
      'step'     => 'step.js?v=20141116',
      'user'     => 'user.js?v=20141022',
      'room'	 => 'room.js?v=20141115',
      'popCheckbox' => 'popCheckbox.js?v=20141027',
      'index'    => 'index.js?v=20141103',
      'head'     => 'head.js?v=20141115',
      'common'   => 'common.js?v=20141116',
      'cookie'   => 'jquery.cookies.js',
);

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
        'application.widgets.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'letmego',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'cache' => array(
			'class' => 'system.caching.CMemCache',
			'servers' => array(
				array('host' => '127.0.0.1', 'port' => 11211, 'weight' => 100),
			),
		),

		// uncomment the following to use a MySQL database
		
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'clientScript' => array(
            'scriptMap' => array(
            	'jquery.js' => false,
            	'jquery.min.js' => false,
            ),
        ),		
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'cookieExpire' => '86400',
		'fmsServer' => YII_DEBUG ? '10.211.55.4' : '211.155.86.148',
		'unLoginUid' => -1,
	),
);