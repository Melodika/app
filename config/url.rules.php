<?php

return [
    'OPTIONS rest/<_c>' => 'rest/options',
    'OPTIONS rest/<_c>/<_a>' => 'rest/options',
    'OPTIONS admin/rest/<_c>' => 'admin/rest/options',
    'OPTIONS admin/rest/<_c>/<_a>' => 'admin/rest/options',
    [
        'class' => yii\rest\UrlRule::class,
        'controller' => 'admin/rest/page',
    ],
];
