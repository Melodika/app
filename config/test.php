<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require __DIR__ . '/main.php',
    [
        'aliases' => [
            '@tests' => '@app/tests',
        ],
        'controllerMap' => [
            'fixture' => [
                'class' => yii\faker\FixtureController::class,
            ],
        ],
    ],
    require __DIR__ . '/test.local.php'
);
