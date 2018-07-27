<?php

namespace app\modules\admin\modules\rest\controllers;

use app\models\User;
use app\modules\admin\modules\rest\components\Controller;
use yii\data\ActiveDataProvider;

class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs(): array
    {
        return [
            'list' => [ 'GET', 'HEAD' ],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function actionList(): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'sort' => [
                'attributes' => [ 'id', 'email', 'create_at', 'updated_at' ],
            ],
        ]);

        return $dataProvider;
    }
}
