<?php

namespace app\tests\unit\fixtures;

use app\models\Raid;
use yii\test\ActiveFixture;

class RaidFixture extends ActiveFixture
{
    public $modelClass = Raid::class;
    public $depends = [ RaidSectionFixture::class ];
}
