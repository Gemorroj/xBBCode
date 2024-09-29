<?php

namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class VkVideoTest extends \PHPUnit\Framework\TestCase
{
    public function testTag()
    {
        $text = 'test [vk]https://m.vk.com/video-177129873_456239415?from=video[/vk].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" src="//vk.com/video_ext.php?id=456239415"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [vk]https://vk.com/video?z=video-177129873_456239415%2Fpl_cat_trends[/vk].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" src="//vk.com/video_ext.php?id=456239415"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());

        $text = 'test [vk]https://vk.com/video-177129873_456239415[/vk].';
        $result = 'test <iframe class="bb" frameborder="0" allowfullscreen="allowfullscreen" width="560" height="315" allow="autoplay; encrypted-media; fullscreen; picture-in-picture;" src="//vk.com/video_ext.php?id=456239415"></iframe>.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        self::assertEquals($result, $xbbcode->getHtml());
    }
}
