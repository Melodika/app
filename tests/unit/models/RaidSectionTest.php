<?php

namespace app\tests\unit\models;

use app\models\Raid;
use app\models\RaidSection;
use app\tests\unit\fixtures\RaidFixture;

class RaidSectionTest extends \Codeception\Test\Unit
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
        $modelSection = RaidSection::find()->bySlug('temporibus-incidunt-commodi-tenetur-fugit')->one();

        $this->assertInstanceOf(RaidSection::class, $modelSection);
    }

    public function testFindByBothSlug(): void
    {
        $modelRaid = Raid::find()->bySlug('voluptas-et-praesentium-unde-voluptatibus-in-omnis-atque')->one();
        $modelSection = $modelRaid->getSections()->bySlug('et-numquam-minus-qui-at-placeat-eum-dolores-occaecati')->one();
        $modelSectionWrong = $modelRaid->getSections()->bySlug('a-possimus-sit-veritatis')->one();

        $this->assertInstanceOf(RaidSection::class, $modelSection);
        $this->assertNull($modelSectionWrong);
    }

    public function testRelations(): void
    {
        $modelSection = RaidSection::findOne(4);

        $this->assertInstanceOf(Raid::class, $modelSection->raid);
    }
}
