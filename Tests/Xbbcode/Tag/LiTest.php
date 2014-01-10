<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class LiTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [ul][li]xBBCode[/li][/ul].';
        $result = 'test <ul class="bb"><li class="bb">xBBCode</li></ul>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagFail()
    {
        $text = 'test [li]xBBCode[/li].';
        $result = 'test [li]xBBCode[/li].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
