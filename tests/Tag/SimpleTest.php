<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class SimpleTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [b]xBBCode[/b].';
        $result = 'test <strong class="bb">xBBCode</strong>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
