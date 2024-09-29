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
 * Class Rutube
 * Класс для тега [rutube].
 */
class Rutube extends TagAbstract
{
    public int $width = 560;
    public int $height = 315;
    public const BEHAVIOUR = 'img';

    protected function getSrc(): string
    {
        $src = $this->attributes['src'] ?? '';

        if (!$src) {
            $src = $this->getTreeText();
        }

        // https://rutube.ru/video/e21f509b303c3672897cfcf85098ae80/ or https://rutube.ru/video/e21f509b303c3672897cfcf85098ae80/?r=wd
        // to
        // https://rutube.ru/play/embed/e21f509b303c3672897cfcf85098ae80/
        $parse = \parse_url($src);

        if (isset($parse['path'])) {
            $id = \substr($parse['path'], \strlen('/video/'));
            $id = \strtok($id, '/');
        } else {
            $id = '';
        }

        return $id ? '//rutube.ru/play/embed/'.\rawurlencode($id) : '';
    }

    protected function getAttributes(): Attributes
    {
        $attr = new Attributes();

        $attr->set('frameborder', '0');
        $attr->set('allowfullscreen', 'allowfullscreen');
        $attr->set('width', (string) $this->width);
        $attr->set('height', (string) $this->height);
        $attr->set('allow', 'autoplay; encrypted-media; fullscreen; picture-in-picture;');

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
