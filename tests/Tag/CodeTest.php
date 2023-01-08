<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class CodeTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [code]xBBCode[/code].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">Text</span></div><code class="bb_code">xBBCode</code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagPhp(): void
    {
        $text = 'test [php]echo "xBBCode";[/php].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><span style="color: #b1b100;">echo</span> <span style="color: #0000ff;">&quot;xBBCode&quot;</span><span style="color: #339933;">;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagPhpKeywords(): void
    {
        $text = 'test [php]function_exists("function_exists");[/php].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><a href="http://www.php.net/function_exists"><span style="color: #990000;">function_exists</span></a><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">&quot;function_exists&quot;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setKeywordLinks(true);
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagRust(): void
    {
        $text = 'test [rust]fn main() {'."\n".
'        println!("Hello World!");'."\n".
'}[/rust].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">Rust</span></div><code class="bb_code"><span style="color: #708;">fn</span> main<span style="">&#40;</span><span style="">&#41;</span> <span style="">&#123;</span><br />'."\n".
'&#160; &#160; &#160; &#160; println<span style="color: #339933;">!</span><span style="">&#40;</span><span style="color: #a11;">&quot;Hello World!&quot;</span><span style="">&#41;</span><span style="color: #339933;">;</span><br />'."\n".
'<span style="">&#125;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
