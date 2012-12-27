<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Bookmore',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.controllers.*', // add for me
    ),
    /*
    'modules'=>array(
        // uncomment the following to enable the Gii tool
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'roman',
             // If removed, Gii defaults to localhost only. Edit carefully to taste.
            //'ipFilters'=>array('127.0.0.1','::1'),
        ),
    ),
    */
    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        'cache'=>array(
            'class'=>'system.caching.CMemCache',
        ),
        /*
        'db'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
        ),
        */
        // uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=bookmore',
            'emulatePrepare' => true,
            'username' => 'roman',
            'password' => 'roman',
            'charset' => 'utf8',
        ),
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        'file'=>array(
            'class'=>'application.extensions.file.CFile',
        ),
        'bmparser'=>array(
            'class'=>'application.extensions.parser.bookmark.CNetscapeBookmarkFormatParser',
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'rgmf@riseup.net',
        'docdir'=>'protected/upload/documents',
        'logodir'=>'protected/upload/logos',
        'tmpdir'=>'protected/upload/tmp',
        'mimeImg'=>array(
                        'application/zip'=>'/images/mime/background.jpg',
                    'text/plain'=>'/images/mime/background.jpg',
                    'application/vnd.oasis.opendocument.text'=>'/images/mime/background.jpg',
                    'application/vnd.oasis.opendocument.spreadsheet'=>'/images/mime/background.jpg',
                    'application/vnd.oasis.opendocument.presentation'=>'/images/mime/background.jpg',
                    'application/vnd.oasis.opendocument.graphics'=>'/images/mime/background.jpg',
                    'application/vnd.oasis.opendocument.base'=>'/images/mime/background.jpg',
                    'application/msword'=>'/images/mime/background.jpg',
                    'application/pdf'=>'/images/mime/background.jpg',
                    'image/gif'=>'/images/mime/background.jpg',
                    'image/jpeg'=>'/images/mime/background.jpg',
                    'image/png'=>'/images/mime/background.jpg',
                    'image/svg+xml'=>'/images/mime/background.jpg',
                    ),
    ),
);
