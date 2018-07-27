<?php

namespace app\models;

use yii\db\ActiveQuery;

class RaidSectionQuery extends ActiveQuery
{
    /**
     * Поиск по слагу.
     * @param string $slug
     * @return $this
     */
    public function bySlug(string $slug): self
    {
        $this->andWhere([ 'slug' => $slug ]);

        return $this;
    }
}
