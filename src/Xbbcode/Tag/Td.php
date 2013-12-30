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
 * Class Td
 * Класс для тега [td]
 */
class Td extends Tag
{
    const BEHAVIOUR = 'td';

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = new Attributes();

        if (isset($this->attributes['width'])) {
            if ($this->isValidSize($this->attributes['width'])) {
                $attr->set('width', $this->attributes['width']);
            }
        }

        if (isset($this->attributes['height'])) {
            if ($this->isValidSize($this->attributes['height'])) {
                $attr->set('height', $this->attributes['height']);
            }
        }

        if (isset($this->attributes['colspan'])) {
            if ($this->isValidNumber($this->attributes['colspan'])) {
                $attr->set('colspan', $this->attributes['colspan']);
            }
        }

        if (isset($this->attributes['rowspan'])) {
            if ($this->isValidNumber($this->attributes['rowspan'])) {
                $attr->set('rowspan', $this->attributes['rowspan']);
            }
        }

        if (isset($this->attributes['align'])) {
            if ($this->isValidAlign($this->attributes['align'])) {
                $attr->set('align', $this->attributes['align']);
            }
        }

        if (isset($this->attributes['valign'])) {
            if ($this->isValidValign($this->attributes['valign'])) {
                $attr->set('valign', $this->attributes['valign']);
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
        return '<td ' . $this->getAttributes() . '>' . $this->getBody() . '</td>';
    }
}
