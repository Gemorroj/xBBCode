<?php

namespace Xbbcode\Tests;

use PHPUnit\Framework\TestCase;
use Xbbcode\Xbbcode;

class XbbcodeTest extends TestCase
{
    public function testBase()
    {
        $text = '
Это [b]пример[/b] работы парсера [url=https://github.com/Gemorroj/xBBCode]xBBCode[/url].
[php]$str = "Hello github!";
echo str_replace("github", "world", $str);
[/]
ссылка https://github.com/Gemorroj/xBBCode
картинка [img]https://0.gravatar.com/avatar/ee4c19dc191da0b322d7cfbb29ae36dc[/img]
:)
https://www.youtube.com/watch?v=qH5IQbpu9NU
';

        $result = '<br />
Это <strong class="bb">пример</strong> работы парсера <a class="bb" href="https://github.com/Gemorroj/xBBCode">xBBCode</a>.<br />
<div class="bb_code"><div class="bb_code_header"><span class="bb_code_lang">PHP</span></div><code class="bb_code"><span style="color: #000088;">$str</span> <span style="color: #339933;">=</span> <span style="color: #0000ff;">&quot;Hello github!&quot;</span><span style="color: #339933;">;</span><br />
<span style="color: #b1b100;">echo</span> <a href="http://www.php.net/str_replace"><span style="color: #990000;">str_replace</span></a><span style="color: #009900;">&#40;</span><span style="color: #0000ff;">&quot;github&quot;</span><span style="color: #339933;">,</span> <span style="color: #0000ff;">&quot;world&quot;</span><span style="color: #339933;">,</span> <span style="color: #000088;">$str</span><span style="color: #009900;">&#41;</span><span style="color: #339933;">;</span><br />
&#160;</code></div><br />
ссылка <a href="https://github.com/Gemorroj/xBBCode" target="_blank">https://github.com/Gemorroj/xBBCode</a><br />
картинка <img class="bb" src="https://0.gravatar.com/avatar/ee4c19dc191da0b322d7cfbb29ae36dc" alt="" /><br />
<img src="/resources/images/smiles/2.gif" alt="Well" /><br />
<a href="https://www.youtube.com/watch?v=qH5IQbpu9NU" target="_blank">https://www.youtube.com/watch?v=qH5IQbpu9NU</a><br />
';

        $xbbcode = new Xbbcode();
        $xbbcode->setKeywordLinks(true);
        $xbbcode->setAutoLinks(true);
        $xbbcode->parse($text);

        self::assertEquals($result, $xbbcode->getHtml());
    }
}
