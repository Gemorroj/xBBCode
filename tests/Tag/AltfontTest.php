<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AltfontTest extends \PHPUnit\Framework\TestCase
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
