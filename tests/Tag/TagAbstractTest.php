<?php

namespace Xbbcode\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Xbbcode\Attributes;
use Xbbcode\Tag\TagAbstract;

class TagAbstractTest extends TestCase
{
    public function testTarget(): void
    {
        $validTargets = ['_blank', '_self', '_parent', '_top', 'any_anchor', '123'];
        $invalidTargets = ['_fake', '_123'];

        $mock = new class extends TagAbstract {
            public function __toString(): string
            {
                throw new \RuntimeException('Not implemented');
            }

            protected function getAttributes(): Attributes
            {
                throw new \RuntimeException('Not implemented');
            }
        };

        $method = new \ReflectionMethod($mock, 'isValidTarget');

        foreach ($validTargets as $target) {
            self::assertTrue($method->invoke($mock, $target));
        }
        foreach ($invalidTargets as $target) {
            self::assertFalse($method->invoke($mock, $target));
        }
    }
}
