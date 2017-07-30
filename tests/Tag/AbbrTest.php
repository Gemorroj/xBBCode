<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AbbrTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [abbr=test]xBBCode[/abbr].';
        $result = 'test <abbr class="bb" title="test">xBBCode</abbr>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
