<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class YoutubeTest extends \PHPUnit\Framework\TestCase
{
    public function testTag(): void
    {
        $text = 'test [youtube]http://www.youtube.com/watch?v=qH5IQbpu9NU[/youtube].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" src="//www.youtube.com/embed/qH5IQbpu9NU"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [youtube]qH5IQbpu9NU[/youtube].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" src="//www.youtube.com/embed/qH5IQbpu9NU"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        foreach ([
            'https://youtu.be/qH5IQbpu9NU',
            'https://www.youtube.com/embed/qH5IQbpu9NU',
            'https://www.youtube.com/shorts/qH5IQbpu9NU',
            'https://www.youtube.com/v/qH5IQbpu9NU',
        ] as $url) {
            $text = 'test [youtube]'.$url.'[/youtube].';

            $xbbcode = new Xbbcode();
            $xbbcode->parse($text);
            self::assertEquals($result, $xbbcode->getHtml());
        }

        $text = 'test [youtube=https://www.youtube.com/watch?v=qH5IQbpu9NU][/youtube].';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
