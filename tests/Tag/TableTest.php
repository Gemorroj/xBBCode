<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class TableTest extends \PHPUnit\Framework\TestCase
{
    public function testTagWithoutTableCells(): void
    {
        $text = 'test [table]xBBCode[/table].';
        $result = 'test <table class="bb"></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTag(): void
    {
        $text = 'test [table][tr][td]xBBCode[/td][/tr][/table].';
        $result = 'test <table class="bb"><tr class="bb"><td class="bb">xBBCode</td></tr></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagWithNewLines(): void
    {
        $text = <<<'BB'
            test [table]
            [tr]
            [td]
            xBBCode
            [/td]
            [/tr]
            [/table].
            BB;
        $result = <<<'HTML'
            test <table class="bb"><tr class="bb"><td class="bb"><br />
            xBBCode<br />
            </td></tr></table>.
            HTML;

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagWithNewLinesAndSpaces(): void
    {
        $text = <<<'BB'
            test [table]
              [tr]
                [td]xBBCode[/td]
              [/tr]
            [/table].
            BB;
        $result = <<<'HTML'
            test <table class="bb"><tr class="bb"><td class="bb">xBBCode</td></tr></table>.
            HTML;

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
