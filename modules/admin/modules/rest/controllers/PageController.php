<?php

namespace app\modules\admin\modules\rest\controllers;

use DateTime;
use app\models\Page;
use app\modules\admin\modules\rest\components\Controller;
use yii\rest\CreateAction;
use yii\rest\DeleteAction;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\UpdateAction;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs(): array
    {
        return [
            'index' => [ 'GET', 'HEAD' ],
            'view' => [ 'GET', 'HEAD' ],
            'create' => [ 'POST' ],
            'update' => [ 'PUT', 'PATCH' ],
            'delete' => [ 'DELETE' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions(): array
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => Page::class,
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => Page::class,
            ],
            'update' => [
                'class' => UpdateAction::class,
                'modelClass' => Page::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'modelClass' => Page::class,
            ],
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    /**
     * Конкретная страница
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): array
    {
        $modelPage = Page::findOne($id);
        if ($modelPage === null) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        return [
            'id' => $modelPage->id,
            'slug' => $modelPage->slug,
            'title' => $modelPage->title,
            'text' => $modelPage->text,
            'createdAt' => (new DateTime($modelPage->created_at))->format(DateTime::ATOM),
            'updatedAt' => (new DateTime($modelPage->updated_at))->format(DateTime::ATOM),
        ];
    }
}
