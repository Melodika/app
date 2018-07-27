<?php

namespace app\modules\rest\controllers;

use Yii;
use app\modules\rest\components\Controller;

class DataController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs(): array
    {
        return [
            'index' => [ 'GET', 'HEAD' ],
        ];
    }

    /**
     * Возвращение общесайтовых данных.
     * @return array
     */
    public function actionIndex(): array
    {
        return [
            'discord' => Yii::$app->settings->get('discord', 'social'),
            'vkontakte' => Yii::$app->settings->get('vkontakte', 'social'),
            'warcraftlogs' => Yii::$app->settings->get('warcraftlogs', 'social'),
            'invite' => Yii::$app->settings->get('invite', 'social'),
        ];
    }
}
