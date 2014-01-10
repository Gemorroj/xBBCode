<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class PTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [p]xBBCode[/p].';
        $result = 'test <p class="bb">xBBCode</p>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
