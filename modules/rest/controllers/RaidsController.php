<?php

namespace app\modules\rest\controllers;

use app\models\Raid;
use app\models\RaidSection;
use app\modules\rest\components\Controller;
use yii\helpers\ArrayHelper;

class RaidsController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'list';

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
     * Возвращение данных по всем активным рейдам.
     * @return array
     */
    public function actionList(): array
    {
        $modelsRaid = Raid::find()->isActive()->all();

        return ArrayHelper::toArray($modelsRaid, [
            Raid::class => [
                'id',
                'slug',
                'name',
                'subtitle',
                'description',
                'name',
                'image' => function ($model) {
                    return $model->getImageUrl(Raid::IMAGE_SMALL);
                },
                'image2x' => function ($model) {
                    return $model->getImageUrl(Raid::IMAGE_SMALL2X);
                },
                'sections' => function ($model) {
                    return ArrayHelper::toArray($model->sections, [
                        RaidSection::class => [
                            'id',
                            'slug',
                            'type',
                            'name',
                            'content',
                            'isDefault' => function ($model) {
                                return $model->is_default;
                            },
                        ],
                    ]);
                },
            ],
        ]);
    }
}
