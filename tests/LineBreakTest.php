<?php

namespace Xbbcode\Tests;

use PHPUnit\Framework\TestCase;
use Xbbcode\Tests\Tag\Fixtures\BrTag;
use Xbbcode\Xbbcode;

class LineBreakTest extends TestCase
{
    private function parse(string $text): string
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setTagHandler('section', BrTag::class);
        $xbbcode->parse($text);

        return $xbbcode->getHtml();
    }

    public function testTrailingLineBreakIsRemoved(): void
    {
        self::assertSame(
            "a<div class=\"bb\">b</div>\nc",
            $this->parse("a\n[section]b[/section]\nc")
        );
    }

    public function testOnlyConfiguredAmountIsRemoved(): void
    {
        self::assertSame(
            "a<br />\n<div class=\"bb\">b</div>\n<br />\nc",
            $this->parse("a\n\n[section]b[/section]\n\nc")
        );
    }
}
