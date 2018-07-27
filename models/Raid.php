<?php

namespace app\models;

use Yii;
use Imagine\Image\ManipulatorInterface;
use mohorev\file\UploadImageBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%raid}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $subtitle
 * @property string $description
 * @property string $image
 * @property integer $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RaidSection[] $sections
 */
class Raid extends \yii\db\ActiveRecord
{
    public const SCENARIO_UPDATE = 'update';
    public const SCENARIO_INSERT = 'insert';

    public const IMAGE_SMALL = 'small';
    public const IMAGE_SMALL2X = 'small@2x';

    protected const FILE_PATH = '@webroot/uploads/raid/{slug}';
    protected const FILE_URL = '@web/uploads/raid/{slug}';

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%raid}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '#',
            'slug' => 'Слаг',
            'name' => 'название',
            'subtitle' => 'Подзаголовок',
            'description' => 'Описание',
            'image' => 'Изображение',
            'is_active' => 'Активен',
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
                'class' => UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => [ self::SCENARIO_UPDATE, self::SCENARIO_INSERT ],
                'path' => self::FILE_PATH,
                'url' => self::FILE_URL,
                'generateNewName' => function ($file) {
                    return 'image.' . $file->extension;
                },
                'thumbs' => [
                    'small' => [ 'width' => 150, 'height' => 150, 'quality' => 85, 'mode' => ManipulatorInterface::THUMBNAIL_OUTBOUND ],
                    'small@2x' => [ 'width' => 300, 'height' => 300, 'quality' => 85, 'mode' => ManipulatorInterface::THUMBNAIL_OUTBOUND ],
                ],
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
     * @inheritdoc
     */
    public function afterDelete(): void
    {
        parent::afterDelete();

        // Удаление директории с файлами
        $path = preg_replace_callback('/{([^}]+)}/', function ($matches) {
            $name = $matches[ 1 ];
            $attribute = ArrayHelper::getValue($this, $name);
            if (is_string($attribute) || is_numeric($attribute)) {
                return $attribute;
            }

            return $matches[ 0 ];
        }, self::FILE_PATH);
        FileHelper::removeDirectory(Yii::getAlias($path));
    }

    /**
     * @return RaidSectionQuery
     */
    public function getSections(): RaidSectionQuery
    {
        return $this->hasMany(RaidSection::class, [ 'raid_id' => 'id' ]);
    }

    /**
     * Возвращает url до изображения.
     * @param string $type
     * @return string
     */
    public function getImageUrl(string $type = self::IMAGE_SMALL): string
    {
        return (string) $this->getThumbUploadUrl('image', $type);
    }

    /**
     * @return RaidQuery
     */
    public static function find(): RaidQuery
    {
        return new RaidQuery(static::class);
    }
}
