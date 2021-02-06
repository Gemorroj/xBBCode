<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class FontTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [font color=green]xBBCode[/font].';
        $result = 'test <font class="bb" color="green">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
