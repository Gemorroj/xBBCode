<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class OlTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [ol]xBBCode[/ol].';
        $result = 'test <ol class="bb">xBBCode</ol>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
