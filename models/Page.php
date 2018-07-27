<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '#',
            'slug' => 'Слаг',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [ [ 'slug', 'title', 'text' ], 'required' ],
            [ [ 'slug', 'title' ], 'string', 'max' => 255 ],
            [ 'slug', 'unique' ],
            [ 'slug', 'match', 'pattern' => '/^[A-Za-z0-9\-_]+$/' ],
            [ 'text', 'string' ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return PageQuery
     */
    public static function find(): PageQuery
    {
        return new PageQuery(static::class);
    }
}
