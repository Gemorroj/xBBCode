<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class UlTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [ul]xBBCode[/ul].';
        $result = 'test <ul class="bb">xBBCode</ul>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
