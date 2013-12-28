<?php

/******************************************************************************
 *                                                                            *
 *   Bbcode.php, v 0.00 2007/04/21 - This is part of xBB library              *
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

// Класс для тега [bbcode]
class Bbcode extends Xbbcode
{
    public $behaviour = 'code';

    public function get_html($tree = null)
    {
        $str = '';
        foreach ($this -> tree as $item) {
            if ('item' === $item['type']) {
                continue;
            }
            $str .= $item['str'];
        }

        $bb = new self($str);

        return '<code class="bb_code">' . $bb -> highlight() . '</code>';
    }
}
