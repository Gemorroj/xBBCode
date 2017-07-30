<?php
namespace Xbbcode\Tests\Tag;

use Xbbcode\Xbbcode;

class ImgTest extends \PHPUnit_Framework_TestCase
{
    public function testTag()
    {
        $text = 'test [img alt="lenin"]https://2.gravatar.com/avatar/ee4c19dc191da0b322d7cfbb29ae36dc[/img] xBBCode.';
        $result = 'test <img class="bb" src="https://2.gravatar.com/avatar/ee4c19dc191da0b322d7cfbb29ae36dc" alt="lenin" /> xBBCode.';

        $xbbcode = new Xbbcode();
        $xbbcode->parse($text);
        $this->assertEquals($result, $xbbcode->getHtml());
    }
}
