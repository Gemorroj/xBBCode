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

use Xbbcode\Xbbcode;


/**
 * Class Youtube
 * Класс для тега [youtube]
 */
class Youtube extends Xbbcode
{
    public $behaviour = 'iframe';

    public function getHtml($tree = null)
    {
        $attr = ' frameborder="0" allowfullscreen="allowfullscreen"';

        $src = isset($this -> attrib['src']) ? $this -> attrib['src'] : '';
        if (!$src) {
            foreach ($this -> tree as $val) {
                if ('text' === $val['type']) {
                    $src .= $val['str'];
                }
            }
        }
        $attr .= ' src="//www.youtube.com/embed/' . $this->htmlspecialchars($src) . '"';

        $width = isset($this -> attrib['width']) ? $this -> attrib['width'] : '';
        if ($width) { $attr .= ' width="' . abs($width) . '"'; }

        $height = isset($this -> attrib['height']) ? $this -> attrib['height'] : '';
        if ($height) { $attr .= ' height="' . abs($height) . '"'; }


        return '<iframe class="bb_youtube" ' . $attr . '>' . parent::getHtml($this -> tree) . '</iframe>';
    }
}
