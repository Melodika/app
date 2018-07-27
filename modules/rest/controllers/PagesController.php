<?php

namespace app\modules\rest\controllers;

use DateTime;
use app\models\Page;
use app\modules\rest\components\Controller;
use yii\web\NotFoundHttpException;

class PagesController extends Controller
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
     * Возвращает данные по конкретной странице.
     * @param string $slug
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionPage(string $slug): array
    {
        $modelPage = Page::find()->bySlug($slug)->one();
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
