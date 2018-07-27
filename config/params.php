<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    [
        'adminEmail' => 'admin@example.com',
    ],
    require __DIR__ . '/params.local.php'
);
