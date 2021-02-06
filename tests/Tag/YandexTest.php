<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class YandexTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [yandex]xBBCode[/yandex].';
        $result = 'test <a class="bb" href="//yandex.com/yandsearch?text=xBBCode">xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [yandex=xBBCode]search[/yandex].';
        $result = 'test <a class="bb" href="//yandex.com/yandsearch?text=xBBCode">search</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
