<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class UlTest extends \PHPUnit\Framework\TestCase
{
    public function testTagWithoutLi(): void
    {
        $text = 'test [ul]xBBCode[/ul].';
        $result = 'test <ul class="bb"></ul>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
