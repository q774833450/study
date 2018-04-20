<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index',
    'aliases'=>[
        '@doctorfu/mailerqueue'=>'@vendor/doctorfu/mailerqueue/src'
    ],
    'components' => [
	'session'=>[
	'class'=>'yii\redis\Session',
	'redis'=>[
	'hostname'=>'localhost',
	'port'=>6379,
	'database'=>'3'
	],
	'keyPrefix'=>'fu_sess_',
	],
	'redis'=>[
		'class'=>'yii\redis\Connection',
		'hostname'=>'localhost',
		'port'=>6379,
		'database'=>0,
	],
        'authManager'=>[
            'class'=>'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
            'defaultRoles' => ['default'],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it i s empty) - this is required by cookie validation
            'cookieValidationKey' => 'q6ga0ArPuP1iWsey2H6aoeWsP7G98FnL',
        ],
        'cache' => [
           'class'=>'yii\redis\Cache',
	'redis'=>[
		'hostname'=>'localhost',
		'port'=>6379,
		'database'=>'2',
		]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'idParam' => '__user',
            'identityCookie' => ['name' => '__user_identity', 'httpOnly' => true],

            'loginUrl'=>['/member/auth']
        ],
        'admin' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\models\Admin',
            'idParam' => '__admin',
            'identityCookie' => ['name' => '__admin_identity', 'httpOnly' => true],
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/public/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'doctorfu\mailerqueue\MailerQueue',
            'db'=>'1',
            'key'=>'mails',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => 'imooc_shop@163.com',
                'password' => 'imooc123',
                'port' => '465',
                'encryption' => 'ssl',
            ],

        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
	
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1'],
    ];
    $config['modules']['admin'] = [
        'class' => 'app\modules\admin',
    ];
}

return $config;
