<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class BdoTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [bdo=ltr]xBBCode[/bdo].';
        $result = 'test <bdo class="bb" dir="ltr">xBBCode</bdo>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
