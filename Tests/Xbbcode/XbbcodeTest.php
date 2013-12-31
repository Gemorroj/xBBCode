<?php
namespace Tests\Xbbcode;

use Xbbcode\Xbbcode;

class XbbcodeTest extends \PHPUnit_Framework_TestCase
{
    public function testTodo()
    {
        $text = '
Это [b]пример[/b] работы парсера [url=https://github.com/Gemorroj/xBBCode]Xbbcode[/url].
[php]$str = "Hello github!";
echo str_replace("github", "world", $str);
[/]
ссылка http://github.com/Gemorroj/xBBCode
:)
';

$result = '<br />
Это <strong class="bb">пример</strong> работы парсера <a class="bb" href="https://github.com/Gemorroj/xBBCode">Xbbcode</a>.<br />
<div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><span style="color: #000088;">$str</span> <span style="color: #339933;">=</span> <span style="color: #0000ff;">&quot;Hello github!&quot;</span><span style="color: #339933;">;</span><br />
<span style="color: #b1b100;">echo</span> <a href="http://www.php.net/str_replace"><span style="color: #990000;">str_replace</span></a><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">&quot;github&quot;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">&quot;world&quot;</span><span style="color: #339933;">,</span> <span style="color: #000088;">$str</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span><br />
&nbsp;</div>
ссылка <a href="http://github.com/Gemorroj/xBBCode" target="_blank">http://github.com/Gemorroj/xBBCode</a><br />
<img src="/resources/images/smiles/2.gif" alt="Well" /><br />
';

        $xbbcode = new Xbbcode();
        $xbbcode->setKeywordLinks(true);
        $xbbcode->setAutoLinks(true);
        $xbbcode->parse($text);

        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
