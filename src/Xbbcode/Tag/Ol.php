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
 * Class Ol
 * Класс для тегов [ol]
 */
class Ol extends Tag
{
    const BR_LEFT = 1;
    const BR_RIGHT = 1;
    const BEHAVIOUR = 'ul';

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = parent::getAttributes();

        if (isset($this->attributes['*'])) {
            if ($this->isValidNumber($this->attributes['*'])) {
                $attr->set('value', $this->attributes['*']);
            }
        }

        if (isset($this->attributes['type'])) {
            if ($this->isValidOlType($this->attributes['type'])) {
                $attr->set('type', $this->attributes['type']);
            }
        }

        return $attr;
    }

    /**
     * Return html code
     *
     * @return string
     */
    public function __toString()
    {
        return '<ol ' . $this->getAttributes() . '>' . $this->getBody() . '</ol>';
    }
}
