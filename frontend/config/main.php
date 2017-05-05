<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'on beforeAction' => function ($event) {
    $actionId = $event->action->id;
    //$controllerId = $event->action->controller->id;   
    //TODO: Check module here
        if (!\Yii::$app->user->isGuest && $actionId!='verify-mobile' && Yii::$app->user->identity->is_mobile_verified!='Y')       
        { //if user mobile is not verify then after login redirect to this controller
            return Yii::$app->response->redirect(['users/verify-mobile']);
        }
    },
    'components' => [
            'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'enableCsrfValidation' => false,
            'cookieValidationKey' => '8Yj94lesMpfiuXUubnFQnBr8j90tFyyv',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
       
        'urlManager' => [
            
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                  'site/reset-password/<link:\w+>'=>'site/reset-password',
                  'site/verify-email/<link:\w+>'=>'site/verify-email',
                  'users/group/<name:(friends|company|family)>'=>'users/show-group',
                  'users/group-map/<id:\d+>'=>'users/group-map',
                  'users/album/<url:\w*>'=>'users/album',
                  'users/album/<url:\w*>/<user_id:\d*>/'=>'users/album',
                  'users/permissions/<tab:(types|user-permissions)>'=>'users/permissions',
                  'admin/activate-account/<user_id:\d+>'=>'admin/activate-account',
                  'admin/deactivate-account/<user_id:\d+>'=>'admin/deactivate-account',

            ],
        ],
        
        'Common'=>[
                'class'=>'frontend\components\Common'
            ],
    ],
    'params' => $params,
];
