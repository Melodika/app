<?php

namespace app\tests\unit\models;

use app\models\Raid;
use app\models\RaidSection;
use app\tests\unit\fixtures\RaidFixture;

class RaidTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures(): array
    {
        return [ 'raids' => RaidFixture::class ];
    }

    public function testFindBySlug(): void
    {
        $modelRaid = Raid::find()->bySlug('tempore-omnis-recusandae-omnis-veritatis-et')->one();

        $this->assertInstanceOf(Raid::class, $modelRaid);
    }

    public function testIsActive(): void
    {
        $modelsRaid = Raid::find()->isActive()->all();

        $this->assertCount(3, $modelsRaid);
    }

    public function testRelations(): void
    {
        $modelRaid = Raid::findOne(4);

        $this->assertCount(2, $modelRaid->sections);
        $this->assertInstanceOf(RaidSection::class, $modelRaid->sections[0]);
    }
}
