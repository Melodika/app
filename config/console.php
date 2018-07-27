<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require __DIR__ . '/main.php',
    [
        'id'   => 'melodika',
        'name' => 'Melodika',
        'controllerNamespace' => 'app\console\controllers',
    ],
    require __DIR__ . '/console.local.php'
);
