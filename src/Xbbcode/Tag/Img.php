<?php

/******************************************************************************
 *                                                                            *
 *   Img.php, v 0.00 2007/04/21 - This is part of xBB library                 *
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

use Xbbcode\Xbbcode;

// Класс для тега [img]
class Img extends Xbbcode
{
    public $behaviour = 'img';

    public function getHtml($tree = null)
    {
        $attr = '';

        if (isset($this -> attrib['alt'])) {
            $attr .= ' alt="' . htmlspecialchars($this -> attrib['alt']) . '"';
        } else {
            // обязательный атрибут
            $attr .= ' alt=""';
        }

        if (isset($this -> attrib['title'])) {
            $attr .= ' title="' . htmlspecialchars($this -> attrib['title']) . '"';
        }
        if (isset($this -> attrib['width'])) {
            $width = (int) $this -> attrib['width'];
            $attr .= $width ? ' width="' . $width . '"' : '';
        }
        if (isset($this -> attrib['height'])) {
            $height = (int) $this -> attrib['height'];
            $attr .= $height ? ' height="' . $height . '"' : '';
        }
        if (isset($this -> attrib['border'])) {
            $border = (int) $this -> attrib['border'];
            $attr .= ' border="' . $border . '"';
        }
        $src = '';
        foreach ($this -> tree as $text) {
            if ('text' === $text['type']) {
                $src .= $text['str'];
            }
        }

        $src = $this -> checkUrl($src);

        return '<img src="' . $src . '" ' . $attr . ' />';
    }
}
