<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class NobbTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [nobb][p]xBBCode[/p][/nobb].';
        $result = 'test [p]xBBCode[/p].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
