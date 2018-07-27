<?php

namespace app\tests\unit\models;

use app\models\Page;
use app\tests\unit\fixtures\PageFixture;

class PageTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _fixtures(): array
    {
        return [ 'pages' => PageFixture::class ];
    }

    public function testFindBySlug(): void
    {
        $modelPage = Page::find()->bySlug('quisquam-molestiae-aspernatur-doloribus-libero-quam-id-iste')->one();

        $this->assertInstanceOf(Page::class, $modelPage);
    }
}
