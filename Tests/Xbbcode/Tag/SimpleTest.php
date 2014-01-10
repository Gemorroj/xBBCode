<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class SimpleTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [b]xBBCode[/b].';
        $result = 'test <strong class="bb">xBBCode</strong>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
