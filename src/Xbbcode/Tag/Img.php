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
 * Class Img
 * Класс для тега [img]
 */
class Img extends Tag
{
    const BEHAVIOUR = 'img';
    const IS_CLOSE = true;

    /**
     * @return string
     */
    protected function getSrc()
    {
        $href = '';
        if (isset($this->attributes['url'])) {
            $href = $this->attributes['url'];
        }
        if (!$href && isset($this->attributes['src'])) {
            $href = $this->attributes['src'];
        }

        if (!$href) {
            $href = $this->getTreeText();
        }

        return $this->parseUrl($href);
    }

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = new Attributes();

        $src = $this->getSrc();
        if ($src) {
            $attr->set('src', $src);
        }

        $alt = '';
        if (isset($this->attributes['alt'])) {
            $alt = $this->attributes['alt'];
        }
        if (!$alt && isset($this->attributes['title'])) {
            $alt = $this->attributes['title'];
        }
        $attr->set('alt', $alt); // обязательный

        if (isset($this->attributes['title'])) {
            $attr->set('title', $this->attributes['title']);
        }

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

        return $attr;
    }


    /**
     * Return html code
     *
     * @return string
     */
    public function __toString()
    {
        return '<img ' . $this->getAttributes() . ' />';
    }
}
