<?php

namespace app\models;

use yii\db\ActiveQuery;

class RaidQuery extends ActiveQuery
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

    /**
     * Только активные.
     * @return $this
     */
    public function isActive(): self
    {
        $this->andWhere([ 'is_active' => true ]);

        return $this;
    }
}
