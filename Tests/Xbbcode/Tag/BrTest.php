<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class BrTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [br]xBBCode.';
        $result = 'test <br class="bb" />xBBCode.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
