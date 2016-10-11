<?php

$config = [
    'id' => 'humhub',
    'bootstrap' => ['humhub\components\bootstrap\LanguageSelector'], 
    'defaultRoute' => '/dashboard/dashboard',
    'layoutPath' => '@humhub/views/layouts',
    'components' => [
        'request' => [
            'class' => 'humhub\components\Request',
        ],
        'user' => [
            'class' => 'humhub\modules\user\components\User',
            'identityClass' => 'humhub\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/auth/login']
        ],
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        'session' => [
            'class' => 'humhub\modules\user\components\Session',
            'sessionTable' => 'user_http_session',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',           
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [
                '/' => 'user/auth/login',
                'custom_profile/default/directory/<pid:\d+>' => 'custom_profile/default/directory',
                'custom_profile/default/view/<uid:\d+>/<pid:\d+>/<pdata:\d+>' => 'custom_profile/default/view',
                'custom_profile/default/edit-profile/<pid:\d+>' => 'custom_profile/default/edit-profile',
                'custom_profile/customprofile/thankyou/<pid:\d+>' => 'custom_profile/customprofile/thankyou',
                 
            ]
        ],
    ],
    'modules' => [
        
    ],
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
    ];
}

return $config;
