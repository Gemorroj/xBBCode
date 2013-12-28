<?php

/******************************************************************************
 *                                                                            *
 *   P.php, v 0.01 2007/04/29 - This is part of xBB library                   *
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

// Класс для тега [p] и тегов [h1], [h2], [h3], [h4], [h5], [h6].
class P extends Xbbcode
{
    public $lbr = 2;
    public $rbr = 2;
    public $behaviour = 'p';

    public function get_html($tree = null)
    {
        $str = "\n<" . $this->tag . ' class="bb"';
        $align = isset($this->attrib['align']) ? $this->attrib['align'] : '';
        if ($align) { $str .= ' align="' . htmlspecialchars($align) . '"'; }

        return $str . '>' . parent::get_html() . '</' . $this->tag . ">\n";
    }
}
