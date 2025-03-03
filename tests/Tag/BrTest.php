<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class BrTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [br]xBBCode.';
        $result = 'test <br class="bb" />xBBCode.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
