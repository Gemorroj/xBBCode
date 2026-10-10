<?php

namespace Xbbcode\Tests\Tag\Fixtures;

use Xbbcode\Attributes;
use Xbbcode\Tag\TagAbstract;

/**
 * Тестовый блочный тег, который игнорирует по одному переводу строки
 * до и после себя (используется для проверки BR_LEFT/BR_RIGHT).
 */
class BrTag extends TagAbstract
{
    public const BEHAVIOUR = 'div';
    public const BR_LEFT = 1;
    public const BR_RIGHT = 1;

    protected function getAttributes(): Attributes
    {
        return new Attributes();
    }

    public function __toString(): string
    {
        return '<div '.$this->getAttributes().'>'.$this->getBody().'</div>';
    }
}
