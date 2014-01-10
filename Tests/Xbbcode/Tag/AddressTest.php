<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [address]xBBCode[/address].';
        $result = 'test <address class="bb">xBBCode</address>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
