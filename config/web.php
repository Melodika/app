<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require __DIR__ . '/main.php',
    [
        /**
         * Настройки системы
         */
        'bootstrap'           => [ 'log' ],
        'controllerNamespace' => 'app\controllers',

        /**
         * Подключённые компоненты
         */
        'components' => [
            'request' => [
                'parsers' => [
                    'application/json' => yii\web\JsonParser::class,
                ],
                'enableCookieValidation' => false,
            ],

            'response' => [
                'format' => \yii\web\Response::FORMAT_JSON,
            ],

            'settings' => [
                'class' => pheme\settings\components\Settings::class,
            ],

            // Управление пользователями
            'user' => [
                'identityClass' => app\models\User::class,
                'enableSession' => false,
                'enableAutoLogin' => false,
            ],
        ],

        /**
         * Модули.
         */
        'modules' => [
            'rest' => [
                'class' => app\modules\rest\RestModule::class,
            ],
            'admin' => [
                'class' => app\modules\admin\AdminModule::class,
            ],
        ],
    ],
    require __DIR__ . '/web.local.php'
);
