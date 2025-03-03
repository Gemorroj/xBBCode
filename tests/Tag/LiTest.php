<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class LiTest extends \PHPUnit\Framework\TestCase
{
    public function testTagWithUl(): void
    {
        $text = 'test [ul][li]xBBCode[/li][/ul].';
        $result = 'test <ul class="bb"><li class="bb">xBBCode</li></ul>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagWithOl(): void
    {
        $text = 'test [ol][li]xBBCode[/li][/ol].';
        $result = 'test <ol class="bb"><li class="bb">xBBCode</li></ol>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail(): void
    {
        $text = 'test [li]xBBCode[/li].';
        $result = 'test [li]xBBCode[/li].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
