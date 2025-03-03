<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class TrTest extends \PHPUnit\Framework\TestCase
{
    public function testTagWithoutTdCell(): void
    {
        $text = 'test [table][tr]xBBCode[/tr][/table].';
        $result = 'test <table class="bb"><tr class="bb"></tr></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail(): void
    {
        $text = 'test [tr]xBBCode[/tr].';
        $result = 'test [tr]xBBCode[/tr].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
