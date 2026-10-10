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
 * Класс для тега [youtube].
 */
class Youtube extends TagAbstract
{
    public const BEHAVIOUR = 'img';
    public int $width = 560;
    public int $height = 315;

    protected function getSrc(): string
    {
        $src = $this->attributes['src'] ?? $this->attributes['youtube'] ?? '';

        if (!$src) {
            $src = $this->getTreeText();
        }

        // https://www.youtube.com/watch?v=qH5IQbpu9NU , https://youtu.be/qH5IQbpu9NU ,
        // https://www.youtube.com/embed/qH5IQbpu9NU , https://www.youtube.com/shorts/qH5IQbpu9NU
        // to
        // https://www.youtube.com/embed/qH5IQbpu9NU
        $id = $src;
        $parse = \parse_url($src);
        if (isset($parse['host'])) {
            $query = [];
            if (isset($parse['query'])) {
                \parse_str($parse['query'], $query);
            }
            if (isset($query['v'])) {
                $id = $query['v'];
            } else {
                $id = $this->getLastPathSegment($parse['path'] ?? '');
            }
        }

        return $id ? '//www.youtube.com/embed/'.\rawurlencode($id) : '';
    }

    protected function getAttributes(): Attributes
    {
        $attr = new Attributes();

        $attr->set('frameborder', '0');
        $attr->set('allowfullscreen', 'allowfullscreen');
        $attr->set('width', (string) $this->width);
        $attr->set('height', (string) $this->height);

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
     * Return html code.
     */
    public function __toString(): string
    {
        return '<iframe '.$this->getAttributes().'></iframe>';
    }
}
