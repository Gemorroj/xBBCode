<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AddressTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [address]xBBCode[/address].';
        $result = 'test <address class="bb">xBBCode</address>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
