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
 * Class Table
 * Класс для тега [table].
 */
class Table extends Tag
{
    public const BEHAVIOUR = 'table';

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = parent::getAttributes();

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

        if (isset($this->attributes['border'])) {
            if ($this->isValidNumber($this->attributes['border'])) {
                $attr->set('border', $this->attributes['border']);
            }
        }

        if (isset($this->attributes['cellspacing'])) {
            if ($this->isValidNumber($this->attributes['cellspacing'])) {
                $attr->set('cellspacing', $this->attributes['cellspacing']);
            }
        }

        if (isset($this->attributes['cellpadding'])) {
            if ($this->isValidNumber($this->attributes['cellpadding'])) {
                $attr->set('cellpadding', $this->attributes['cellpadding']);
            }
        }

        if (isset($this->attributes['align'])) {
            if ($this->isValidAlign($this->attributes['align'])) {
                $attr->set('align', $this->attributes['align']);
            }
        }

        return $attr;
    }

    /**
     * Return html code.
     */
    public function __toString(): string
    {
        return '<table '.$this->getAttributes().'>'.$this->getBody().'</table>';
    }
}
