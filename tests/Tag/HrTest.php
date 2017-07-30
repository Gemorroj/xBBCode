<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class HrTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [hr]xBBCode.';
        $result = 'test <hr class="bb" />xBBCode.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
