<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class ColorTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [color=red]xBBCode[/color].';
        $result = 'test <font class="bb" color="red">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
