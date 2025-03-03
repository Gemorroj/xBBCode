<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class AcronymTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [acronym=test]xBBCode[/acronym].';
        $result = 'test <acronym class="bb" title="test">xBBCode</acronym>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
