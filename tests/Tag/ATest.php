<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class ATest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [url=https://github.com/Gemorroj/xBBCode]xBBCode - привет мир[/url].';
        $result = 'test <a class="bb" href="https://github.com/Gemorroj/xBBCode">xBBCode - привет мир</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(true);
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(false);
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [url]https://github.com/Gemorroj/xBBCode#привет[/url].';
        $result = 'test <a class="bb" href="https://github.com/Gemorroj/xBBCode#%D0%BF%D1%80%D0%B8%D0%B2%D0%B5%D1%82">https://github.com/Gemorroj/xBBCode#привет</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(true);
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(false);
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
