<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class UlTest extends \PHPUnit\Framework\TestCase
{
    public function testTagWithoutLi()
    {
        $text = 'test [ul]xBBCode[/ul].';
        $result = 'test <ul class="bb"></ul>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
