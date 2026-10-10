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

namespace Xbbcode;

class Attributes extends \ArrayObject implements \Stringable
{
    public function __construct()
    {
        parent::__construct(['class' => 'bb']);
    }

    public function getAttributeValue(string $name): string
    {
        return $this->offsetGet($name);
    }

    public function set(string $name, string $value): self
    {
        $this->offsetSet($name, $value);

        return $this;
    }

    public function add(string $name, string $value): self
    {
        if ($this->offsetExists($name)) {
            $this->offsetSet($name, $this->offsetGet($name).' '.$value);
        } else {
            $this->set($name, $value);
        }

        return $this;
    }

    public function remove(string $name): self
    {
        $this->offsetUnset($name);

        return $this;
    }

    public function __toString(): string
    {
        $str = '';
        foreach ($this->getIterator() as $name => $value) {
            $str .= \htmlspecialchars($name, \ENT_NOQUOTES).'="'.\htmlspecialchars($value).'" ';
        }

        return \rtrim($str);
    }
}
