<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AcronymTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [acronym=test]xBBCode[/acronym].';
        $result = 'test <acronym class="bb" title="test">xBBCode</acronym>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
