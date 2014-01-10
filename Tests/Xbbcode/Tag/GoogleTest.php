<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class GoogleTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [google]xBBCode[/google].';
        $result = 'test <a class="bb" href="//www.google.com/search?q=xBBCode">xBBCode</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());


        $text = 'test [google=xBBCode]search[/google].';
        $result = 'test <a class="bb" href="//www.google.com/search?q=xBBCode">search</a>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
