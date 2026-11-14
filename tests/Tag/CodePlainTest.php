<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class CodePlainTest extends \PHPUnit\Framework\TestCase
{
    public function testRendersSemanticMarkupWithoutGeshi(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setCodeHighlighting(false);
        $xbbcode->parse('[php]<?php echo "hi";[/php]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('<pre><code class="language-php">', $html);
        self::assertStringContainsString('&lt;?php echo &quot;hi&quot;;', $html);
        self::assertStringContainsString('<span class="bb_code_lang">PHP</span>', $html);
        self::assertStringNotContainsString('style=', $html);
    }

    public function testUsesLanguageSynonymForClassAndOriginalLabelForTitle(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setCodeHighlighting(false);
        $xbbcode->parse('[code=js]var x = 1;[/code]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('<code class="language-javascript">', $html);
        self::assertStringContainsString('<span class="bb_code_lang">JS</span>', $html);
    }

    public function testPlainLanguageNamesDoNotUseGeshiSuffixes(): void
    {
        $cases = [
            'algol' => 'algol',
            'c#' => 'csharp',
            'c++' => 'cpp',
            'c_loadrunner' => 'c',
            'c_mac' => 'c',
            'c_winapi' => 'c',
            'cpp-qt' => 'cpp',
            'cpp-winapi' => 'cpp',
            'ecmascript' => 'javascript',
            'f#' => 'fsharp',
            'f++' => 'fsharp',
            'html' => 'html',
            'html4strict' => 'html',
            'html5' => 'html',
            'java5' => 'java',
            'jquery' => 'javascript',
            'js' => 'javascript',
            'mxml' => 'xml',
            'mysql' => 'sql',
            'objc' => 'objectivec',
            'ocaml' => 'ocaml',
            'oracle' => 'sql',
            'oracle8' => 'sql',
            'oracle11' => 'sql',
            'pgsql' => 'sql',
            'php-brief' => 'php',
            'plsql' => 'sql',
            'postgresql' => 'sql',
            'properties' => 'ini',
            'rails' => 'ruby',
            'rsplus' => 'r',
            'sass' => 'scss',
            't-sql' => 'sql',
            'tsql' => 'sql',
            'vb' => 'vbnet',
            'vb.net' => 'vbnet',
        ];

        foreach ($cases as $input => $expected) {
            $xbbcode = new Xbbcode();
            $xbbcode->setCodeHighlighting(false);
            $xbbcode->parse('[code='.$input.']x[/code]');

            self::assertStringContainsString('<code class="language-'.$expected.'">', $xbbcode->getHtml(), $input);
        }
    }

    public function testLanguageLookupIsCaseInsensitive(): void
    {
        $cases = [
            'HTML5' => 'html',
            'JS' => 'javascript',
            'Oracle8' => 'sql',
            'PHP' => 'php',
            'TSQL' => 'sql',
        ];

        foreach ($cases as $input => $expected) {
            $xbbcode = new Xbbcode();
            $xbbcode->setCodeHighlighting(false);
            $xbbcode->parse('[code='.$input.']x[/code]');

            self::assertStringContainsString('<code class="language-'.$expected.'">', $xbbcode->getHtml(), $input);
        }
    }

    public function testOriginalLanguageCaseIsKeptForTitle(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setCodeHighlighting(false);
        $xbbcode->parse('[code=HTML5]x[/code]');

        self::assertStringContainsString('<span class="bb_code_lang">HTML5</span>', $xbbcode->getHtml());
    }

    public function testPlainModeExposesDataAttributes(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setCodeHighlighting(false);
        $xbbcode->parse('[code=php num=10 tab=4 extra=2,5 links=true]x[/code]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('data-start="10"', $html);
        self::assertStringContainsString('data-tab-width="4"', $html);
        self::assertStringContainsString('data-highlight-lines="2,5"', $html);
        self::assertStringContainsString('data-keyword-links="true"', $html);
    }

    public function testPlainModeOmitsZeroTabWidth(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->setCodeHighlighting(false);
        $xbbcode->parse('[code=php tab=0]x[/code]');

        self::assertStringNotContainsString('data-tab-width', $xbbcode->getHtml());
    }

    public function testDefaultStillUsesGeshi(): void
    {
        $xbbcode = new Xbbcode();
        $xbbcode->parse('[php]echo 1;[/php]');

        $html = $xbbcode->getHtml();

        self::assertStringContainsString('<span class="kw1">echo</span>', $html);
        self::assertStringNotContainsString('style=', $html);
    }

    public function testCodeHighlightingCanBeToggled(): void
    {
        $xbbcode = new Xbbcode();

        self::assertTrue($xbbcode->getCodeHighlighting());

        $xbbcode->setCodeHighlighting(false);

        self::assertFalse($xbbcode->getCodeHighlighting());
    }
}
