<?php

namespace app\modules\admin\modules\rest\controllers;

use Yii;
use app\modules\admin\modules\rest\components\Controller;

class OptionsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        unset($behaviors[ 'authenticator' ]);

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    protected function verbs(): array
    {
        return [
            'index' => [ 'OPTIONS' ],
        ];
    }

    /**
     * Ответ на OPTIONS запрос.
     */
    public function actionIndex(): void
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }

        Yii::$app->getResponse()->getHeaders()->set('Allow', 'GET,POST,DELETE,HEAD,OPTIONS');
    }
}
