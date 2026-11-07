<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class SpoilerDetailsTest extends \PHPUnit\Framework\TestCase
{
    public function testRendersNativeDetails(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->parse('[hide]secret[/hide]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('<details class="bb_spoiler">', $html);
        self::assertStringContainsString('<summary>', $html);
        self::assertStringContainsString('secret', $html);
        self::assertStringNotContainsString('<input', $html);
        self::assertStringNotContainsString('onclick=', $html);
        self::assertStringNotContainsString('display: none', $html);
    }

    public function testRendersShowAndHideLabels(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->parse('[spoiler]secret[/spoiler]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('bb_spoiler_show', $html);
        self::assertStringContainsString('<span class="bb_spoiler_hide" hidden>', $html);
    }

    public function testEscapesCustomLabels(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setTagHandler('spoiler', EscapedSpoilerDetails::class);
        $xbbcode->parse('[spoiler]secret[/spoiler]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('&lt;Показать&gt;', $html);
        self::assertStringContainsString('&quot;Скрыть&quot;', $html);
    }
}

final class EscapedSpoilerDetails extends \Xbbcode\Tag\SpoilerDetails
{
    public string $showButton = '<Показать>';
    public string $hideButton = '"Скрыть"';
}
