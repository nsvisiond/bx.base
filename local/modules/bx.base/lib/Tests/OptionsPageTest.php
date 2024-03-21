<?php

namespace BX\Base\Tests;

use Bitrix\Main\Loader;
use BX\Base\Options\OptionsPage;
use PHPUnit\Framework\TestCase;

/**
 * @covers OptionsPage
 */
class OptionsPageTest extends TestCase
{

    private const MODULE_ID = 'bx.base';

    public function testIsOptionsPageCreated(): void
    {
        Loader::includeModule(self::MODULE_ID);
        $_GET['mid'] = self::MODULE_ID;
        $optionsPage = new OptionsPage();
        $this->assertInstanceOf(OptionsPage::class, $optionsPage);
    }
}