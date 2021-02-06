<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class HrTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [hr]xBBCode.';
        $result = 'test <hr class="bb" />xBBCode.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
