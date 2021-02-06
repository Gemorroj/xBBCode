<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class EmailTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [email]xBBCode@xBBCode.xBBCode[/email].';
        $result = 'test <a class="bb" href="mailto:xBBCode@xBBCode.xBBCode">xBBCode@xBBCode.xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
