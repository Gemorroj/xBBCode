<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class AltfontTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [font=verdana]xBBCode[/font].';
        $result = 'test <font class="bb" face="verdana">xBBCode</font>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
