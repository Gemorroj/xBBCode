<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class ColorTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [color=red]xBBCode[/color].';
        $result = 'test <font class="bb" color="red">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
