<?php

namespace app\modules\rest\components;

class Controller extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        // Всегда json, выставлено глобально
        unset($behaviors[ 'contentNegotiator' ]);
        // Не нужен
        unset($behaviors[ 'rateLimiter' ]);
        // Аутентификации нет
        unset($behaviors[ 'authenticator' ]);

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

        return $behaviors;
    }
}
