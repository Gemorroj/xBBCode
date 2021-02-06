<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class GoogleTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [google]xBBCode[/google].';
        $result = 'test <a class="bb" href="//www.google.com/search?q=xBBCode">xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [google=xBBCode]search[/google].';
        $result = 'test <a class="bb" href="//www.google.com/search?q=xBBCode">search</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
