<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class NobbTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [nobb][p]xBBCode[/p][/nobb].';
        $result = 'test [p]xBBCode[/p].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
