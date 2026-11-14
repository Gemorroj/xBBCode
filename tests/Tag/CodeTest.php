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
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><span class="kw1">echo</span> <span class="st0">&quot;xBBCode&quot;</span><span class="sy0">;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagPhpKeywords(): void
    {
        $text = 'test [php]function_exists("function_exists");[/php].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><a href="http://www.php.net/function_exists"><span class="kw3">function_exists</span></a><span class="br0">&#40;</span><span class="st0">&quot;function_exists&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setKeywordLinks(true);
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagUnknownLanguage(): void
    {
        $text = 'test [code=doesnotexist]xBBCode[/code].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">Text</span></div><code class="bb_code">xBBCode</code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagRust(): void
    {
        $text = 'test [rust]fn main() {'."\n".
'        println!("Hello World!");'."\n".
'}[/rust].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">Rust</span></div><code class="bb_code"><span class="kw1">fn</span> main<span class="br0">&#40;</span><span class="br0">&#41;</span> <span class="br0">&#123;</span><br />'."\n".
'&#160; &#160; &#160; &#160; println<span class="sy0">!</span><span class="br0">&#40;</span><span class="st0">&quot;Hello World!&quot;</span><span class="br0">&#41;</span><span class="sy0">;</span><br />'."\n".
'<span class="br0">&#125;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
