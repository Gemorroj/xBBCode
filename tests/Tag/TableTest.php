<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [table]xBBCode[/table].';
        $result = 'test <table class="bb">xBBCode</table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
