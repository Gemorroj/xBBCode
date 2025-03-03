<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class PTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [p]xBBCode[/p].';
        $result = 'test <p class="bb">xBBCode</p>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
