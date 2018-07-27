<?php

namespace app\modules\rest\controllers;

use Yii;
use app\modules\rest\components\Controller;

class OptionsController extends Controller
{
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
     * @throws \yii\base\ExitException
     */
    public function actionIndex(): void
    {
        Yii::$app->getResponse()->getHeaders()->set('Allow', 'GET,POST,DELETE,HEAD,OPTIONS');
        Yii::$app->end();
    }
}
