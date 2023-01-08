<?php

/******************************************************************************
 *                                                                            *
 *   Copyright (C) 2006-2007  Dmitriy Skorobogatov  dima@pc.uz                *
 *                                                                            *
 *   This program is free software; you can redistribute it and/or modify     *
 *   it under the terms of the GNU General Public License as published by     *
 *   the Free Software Foundation; either version 2 of the License, or        *
 *   (at your option) any later version.                                      *
 *                                                                            *
 *   This program is distributed in the hope that it will be useful,          *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of           *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            *
 *   GNU General Public License for more details.                             *
 *                                                                            *
 *   You should have received a copy of the GNU General Public License        *
 *   along with this program; if not, write to the Free Software              *
 *   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA *
 *                                                                            *
 ******************************************************************************/

namespace Xbbcode\Tag;

use Xbbcode\Attributes;

/**
 * Class Bbcode
 * Класс для тега [bbcode].
 */
class Bbcode extends TagAbstract
{
    public const BEHAVIOUR = 'code';

    protected function getAttributes(): Attributes
    {
        $attr = new Attributes();

        $attr->add('class', 'bb_code');

        return $attr;
    }

    /**
     * Парсим текст
     */
    protected function build(): void
    {
        $this->parse($this->getTreeText());
    }

    /**
     * Return html code.
     */
    public function __toString(): string
    {
        $this->build();

        return '<code '.$this->getAttributes().'>'.$this->highlight().'</code>';
    }
}
