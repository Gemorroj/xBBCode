<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class FontTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [font color=green]xBBCode[/font].';
        $result = 'test <font class="bb" color="green">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagSize(): void
    {
        $text = 'test [font size=5]xBBCode[/font].';
        $result = 'test <font class="bb" size="5">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [font size=99]xBBCode[/font].';
        $result = 'test <font class="bb">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
