<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class CaptionTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [table][caption]xBBCode[/caption][/table].';
        $result = 'test <table class="bb"><caption class="bb">xBBCode</caption></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail(): void
    {
        $text = 'test [caption]xBBCode[/caption].';
        $result = 'test [caption]xBBCode[/caption].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
