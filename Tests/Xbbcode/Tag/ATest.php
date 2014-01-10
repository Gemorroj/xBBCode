<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class ATest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [url=https://github.com/Gemorroj/xBBCode]xBBCode[/url].';
        $result = 'test <a class="bb" href="https://github.com/Gemorroj/xBBCode">xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(true);
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(false);
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());


        $text = 'test [url]https://github.com/Gemorroj/xBBCode[/url].';
        $result = 'test <a class="bb" href="https://github.com/Gemorroj/xBBCode">https://github.com/Gemorroj/xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(true);
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());

        $xbbcode = new Xbbcode();
        $xbbcode->setAutoLinks(false);
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
