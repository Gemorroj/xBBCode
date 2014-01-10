<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class FontTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [font color=green]xBBCode[/font].';
        $result = 'test <font class="bb" color="green">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
