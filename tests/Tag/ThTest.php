<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class ThTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [table][tr][th]xBBCode[/th][/tr][/table].';
        $result = 'test <table class="bb"><tr class="bb"><th class="bb">xBBCode</th></tr></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail()
    {
        $text = 'test [th]xBBCode[/th].';
        $result = 'test [th]xBBCode[/th].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
