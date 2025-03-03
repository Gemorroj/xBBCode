<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AbbrTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [abbr=test]xBBCode[/abbr].';
        $result = 'test <abbr class="bb" title="test">xBBCode</abbr>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
