<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class TrTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [table][tr]xBBCode[/tr][/table].';
        $result = 'test <table class="bb"><tr class="bb">xBBCode</tr></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail()
    {
        $text = 'test [tr]xBBCode[/tr].';
        $result = 'test [tr]xBBCode[/tr].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
