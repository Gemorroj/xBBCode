<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AlignTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [align=justify]xBBCode[/align].';
        $result = 'test <div class="bb" align="justify">xBBCode</div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
