<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SOUNDO',
	'timeZone' => 'Europe/Rome',
	'sourceLanguage' => 'en',

	// preloading 'log' component e yiibooster
	'preload'=>array('log', 'bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'application.vendors.phpexcel.PHPExcel',
		'application.modules.srbac.controllers.SBaseController',
		'application.modules.srbac.models.*',
		'system.gii.components.Pear.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'generatorPaths' => array(
			    'bootstrap.gii',
			),
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'srbac' => array(
			'userclass' => 'User', //default: User 
			'userid' => 'id', //default: userid 
			'username' => 'username', //default:username 
			'delimeter' => '@', //default:-
			'debug' => true, //default :false
			'pageSize' => 30, // default : 15
			'superUser' => 'Authorizer', //default: Authorizer 
			'css' => 'srbac.css', //default: srbac.css 
			'layout' => 'application.views.layouts.main', //default: application.views.layouts.main,must be an existing alias 
			'notAuthorizedView' => 'srbac.views.authitem.unauthorized', // default:srbac.views.authitem.unauthorized, must be an existing alias
			'alwaysAllowed' => array(//default: array()
			'SiteLogin', 'SiteLogout', 'SiteIndex', 'SiteAdmin',
			'SiteError', 'SiteContact'),
			'userActions' => array('Show', 'View', 'List'), //default: array() 
			'listBoxNumberOfLines' => 15, //default : 10
			'imagesPath' => 'srbac.images', // default: srbac.images 
			'imagesPack' => 'tango', //default: noia
			'iconText' => true, // default : false 
			'header' => 'srbac.views.authitem.header', //default : srbac.views.authitem.header, must be an existing alias
			'footer' => 'srbac.views.authitem.footer', //default: srbac.views.authitem.footer, must be an existing alias
			'showHeader' => true, // default: false
			'showFooter' => true, // default: false 
			'alwaysAllowedPath' => 'srbac.components', // default: srbac.components, must be an existing alias
		),
		
	),

	// application components
	'components'=>array(
		'service' => array('class' => 'Service'),
		'lov' => array('class' => 'ListOfValues'),		
		'clientScript' => array(
			'scriptMap' => array(
				'jquery.js' => false,
				'jquery.min.js' => false
			),
		),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'autoUpdateFlash' => false, // add this line to disable the flash counter
		),

		'authManager' => array(
			// Path to SDbAuthManager in srbac module if you want to use case insensitive access checking (or CDbAuthManager for case sensitive access checking)
			'class' => 'application.modules.srbac.components.SDbAuthManager',
			// The database component used
			'connectionID' => 'db',
			// The itemTable name (default:authitem)
			'itemTable' => 'srbac_items',
			// The assignmentTable name (default:authassignment)
			'assignmentTable' => 'srbac_assignments',
			// The itemChildTable name (default:authitemchild)
			'itemChildTable' => 'srbac_itemchildren',
		),
		'bootstrap' => array(
		    'class' =>  'bootstrap.components.Bootstrap',
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'rules' => array(
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		),
		'db'=>array(
		    'class'=>'CDbConnection',
		    'connectionString' => 'mysql:host=localhost;dbname=soundo',
		    'emulatePrepare' => true,
		    'username' => 'soundo',
		    'password' => 'soundo',
		    'charset' => 'utf8',
		    'enableParamLogging' => true,
		    'enableProfiling' => true,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		// Logger
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'warning',
					'logFile' => 'warning.log',
					'maxFileSize' => 10240,
					'maxLogFiles' => 7
				),
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'info',
					'logFile' => 'info.log',
					'maxFileSize' => 10240,
					'maxLogFiles' => 7
				),
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error',
					'logFile' => 'error.log',
					'maxFileSize' => 10240,
					'maxLogFiles' => 7
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		'baseurl' => "http://localhost/mvpfluid",
		// this is used in contact page
		'adminEmail' => '',		
	),
);
