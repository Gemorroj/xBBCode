<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AlignTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [align=justify]xBBCode[/align].';
        $result = 'test <div class="bb" align="justify">xBBCode</div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
