<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class RutubeTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [rutube]https://rutube.ru/video/e21f509b303c3672897cfcf85098ae80[/rutube].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" src="//rutube.ru/play/embed/e21f509b303c3672897cfcf85098ae80"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [rutube]https://rutube.ru/video/e21f509b303c3672897cfcf85098ae80/?r=wd[/rutube].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" src="//rutube.ru/play/embed/e21f509b303c3672897cfcf85098ae80"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
