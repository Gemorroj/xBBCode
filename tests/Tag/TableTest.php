<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class TableTest extends \PHPUnit_Framework_TestCase
{
    public function testTagWithoutTableCells()
    {
        $text = 'test [table]xBBCode[/table].';
        $result = 'test <table class="bb"></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTag()
    {
        $text = 'test [table][tr][td]xBBCode[/td][/tr][/table].';
        $result = 'test <table class="bb"><tr class="bb"><td class="bb">xBBCode</td></tr></table>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagWithNewLines()
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
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagWithNewLinesAndSpaces()
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
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
