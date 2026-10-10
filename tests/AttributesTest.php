<?php

namespace Xbbcode\Tests;

use PHPUnit\Framework\TestCase;
use Xbbcode\Attributes;

class AttributesTest extends TestCase
{
    public function testDefault(): void
    {
        $attributes = new Attributes();

        self::assertEquals('class="bb"', (string) $attributes);
    }

    public function testSetAddRemove(): void
    {
        $attributes = new Attributes();
        $attributes->set('href', 'https://example.com');
        $attributes->add('class', 'bb_link');
        $attributes->add('class', 'bb_extra');

        self::assertEquals('https://example.com', $attributes->getAttributeValue('href'));
        self::assertEquals('class="bb bb_link bb_extra"', (string) $attributes->remove('href'));
    }

    public function testAddNewAttribute(): void
    {
        $attributes = new Attributes();
        $attributes->add('id', 'foo');

        self::assertEquals('class="bb" id="foo"', (string) $attributes);
    }

    public function testArrayAccessIsConsistent(): void
    {
        $attributes = new Attributes();
        $attributes->set('href', 'https://example.com');

        self::assertEquals('https://example.com', $attributes['href']);
        self::assertTrue(isset($attributes['href']));
        self::assertCount(2, $attributes);
        self::assertSame(['class' => 'bb', 'href' => 'https://example.com'], $attributes->getArrayCopy());
    }

    public function testEscaping(): void
    {
        $attributes = new Attributes();
        $attributes->set('title', '"<script>');

        self::assertEquals('class="bb" title="&quot;&lt;script&gt;"', (string) $attributes);
    }
}
