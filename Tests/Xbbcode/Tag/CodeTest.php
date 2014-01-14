<?php
namespace Tests\Xbbcode\Tag;

use Xbbcode\Xbbcode;

class CodeTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [code]xBBCode[/code].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">Text</span></div><code class="bb_code">xBBCode</code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagPhp()
    {
        $text = 'test [php]echo "xBBCode";[/php].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><span style="color: #b1b100;">echo</span> <span style="color: #0000ff;">&quot;xBBCode&quot;</span><span style="color: #339933;">;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }

    public function testTagPhpKeywords()
    {
        $text = 'test [php]function_exists("function_exists");[/php].';
        $result = 'test <div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><a href="http://www.php.net/function_exists"><span style="color: #990000;">function_exists</span></a><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">&quot;function_exists&quot;</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span></code></div>.';

        $xbbcode = new Xbbcode();
        $xbbcode->setKeywordLinks(true);
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
