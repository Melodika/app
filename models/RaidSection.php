<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%raid_section}}".
 *
 * @property integer $id
 * @property integer $raid_id
 * @property string $slug
 * @property string $type
 * @property string $name
 * @property string $content
 * @property string $is_default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Raid $raid
 */
class RaidSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%raid_section}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '#',
            'raid_id' => 'Рейд',
            'slug' => 'Слаг',
            'type' => 'Тип',
            'name' => 'Название',
            'content' => 'Содержимое',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return RaidQuery
     */
    public function getRaid(): RaidQuery
    {
        return $this->hasOne(Raid::class, [ 'id' => 'raid_id' ]);
    }

    /**
     * @return RaidSectionQuery
     */
    public static function find(): RaidSectionQuery
    {
        return new RaidSectionQuery(static::class);
    }
}
