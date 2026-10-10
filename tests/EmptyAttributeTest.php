<?php

namespace Xbbcode\Tests;

use PHPUnit\Framework\TestCase;
use Xbbcode\Xbbcode;

class EmptyAttributeTest extends TestCase
{
    private function parse(string $text): string
    {
        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);

        return $xbbcode->getHtml();
    }

    public function testEmptyUnquotedAttribute(): void
    {
        $cases = [
            '[url=]x[/url]' => '<a class="bb" href="x">x</a>',
            '[url= ]x[/url]' => '<a class="bb" href="x">x</a>',
            '[color=]x[/color]' => '<font class="bb" color="">x</font>',
            '[img=]x[/img]' => '<img class="bb" src="x" alt="" />',
            '[b=]x[/b]' => '<strong class="bb">x</strong>',
        ];

        foreach ($cases as $text => $expected) {
            self::assertSame($expected, $this->parse($text), $text);
        }
    }
}
