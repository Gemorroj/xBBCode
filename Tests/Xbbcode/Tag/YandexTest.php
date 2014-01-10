<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class YandexTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [yandex]xBBCode[/yandex].';
        $result = 'test <a class="bb" href="//yandex.com/yandsearch?text=xBBCode">xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());


        $text = 'test [yandex=xBBCode]search[/yandex].';
        $result = 'test <a class="bb" href="//yandex.com/yandsearch?text=xBBCode">search</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
