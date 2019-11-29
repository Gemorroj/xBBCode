<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class OlTest extends \PHPUnit\Framework\TestCase
{
    public function testTagWithoutLi()
    {
        $text = 'test [ol]xBBCode[/ol].';
        $result = 'test <ol class="bb"></ol>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
