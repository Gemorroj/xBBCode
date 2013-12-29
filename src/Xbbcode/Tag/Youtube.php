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
 * Class Youtube
 * Класс для тега [youtube]
 */
class Youtube extends Tag
{
    /**
     * @return string
     */
    protected function getSrc()
    {
        $src = isset($this->attributes['src']) ? $this->attributes['src'] : '';

        if (!$src) {
            foreach ($this->tree as $val) {
                if ('text' === $val['type']) {
                    $src .= $val['str'];
                }
            }
        }

        $parse = parse_url($src);
        if (isset($parse['path']) && isset($parse['query'])) {
            parse_str($parse['query'], $query);
            if (isset($query['v'])) {
                $src = $query['v'];
            }
        }

        return '//www.youtube.com/embed/' . rawurlencode($src);
    }

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = new Attributes();

        $attr->set('frameborder', '0');
        $attr->set('allowfullscreen', 'allowfullscreen');

        $src = $this->getSrc();
        if ($src) {
            $attr->set('src', $src);
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

        return $attr;
    }


    /**
     * Return html code
     *
     * @return string
     */
    public function __toString()
    {
        return '<iframe ' . $this->getAttributes() . '></iframe>';
    }
}
