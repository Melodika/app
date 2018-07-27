<?php

namespace app\modules\admin\modules\rest\components;

use yii\filters\auth\HttpBearerAuth;

class Controller extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public $serializer = [
        'class' => \yii\rest\Serializer::class,
        'collectionEnvelope' => 'data',
        'linksEnvelope' => 'links',
        'metaEnvelope' => 'meta',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        // Всегда json, выставлено в настройках модуля
        unset($behaviors[ 'contentNegotiator' ]);
        // Не нужен
        unset($behaviors[ 'rateLimiter' ]);

        // CORS
        $behaviors[ 'corsFilter' ] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => [ '*' ],
                'Access-Control-Request-Method' => [ 'GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS' ],
                'Access-Control-Request-Headers' => [ '*' ],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [ 'Authorization' ],
            ],
        ];

        // Фильтр надо поместить в самый конец, иначе как минимум cors не ставятся т.к. отрабатываю после него
        $authenticator = $behaviors[ 'authenticator' ];
        unset($behaviors[ 'authenticator' ]);
        $behaviors[ 'authenticator' ] = $authenticator;
        // Аутентификация по JWT
        $behaviors[ 'authenticator' ][ 'authMethods' ] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }
}
