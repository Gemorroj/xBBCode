<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class TdTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [table][tr][td]xBBCode[/td][/tr][/table].';
        $result = 'test <table class="bb"><tr class="bb"><td class="bb">xBBCode</td></tr></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail(): void
    {
        $text = 'test [td]xBBCode[/td].';
        $result = 'test [td]xBBCode[/td].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
