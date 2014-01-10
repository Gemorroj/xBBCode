<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class BbcodeTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [bbcode]xBBCode [b]strong[/b] string [/bbcode].';
        $result = 'test <code class="bb bb_code">xBBCode <span class="bb_tag"><span class="bb_bracket">[</span><span class="bb_tagname">b</span><span class="bb_bracket">]</span></span>strong<span class="bb_tag"><span class="bb_bracket">[</span><span class="bb_slash">/</span><span class="bb_tagname">b</span><span class="bb_bracket">]</span></span> string </code>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
