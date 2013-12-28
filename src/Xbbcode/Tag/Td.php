<?php

/******************************************************************************
 *                                                                            *
 *   Td.php, v 0.00 2007/04/21 - This is part of xBB library                  *
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

// Класс для тега [td]
class Td extends Xbbcode
{
    public $behaviour = 'td';

    public function get_html($tree = null)
    {
        $attr = 'class="bb"';
        $width = isset($this -> attrib['width']) ? $this -> attrib['width'] : '';
        if ($width) { $attr .= ' width="' . htmlspecialchars($width) . '"'; }
        $height = isset($this -> attrib['height']) ? $this -> attrib['height'] : '';
        if ($height) { $attr .= ' height="' . htmlspecialchars($height) . '"'; }
        $align = isset($this -> attrib['align']) ? $this -> attrib['align'] : '';
        if ($align) { $attr .= ' align="' . htmlspecialchars($align) . '"'; }
        $valign = isset($this -> attrib['valign']) ? $this -> attrib['valign'] : '';
        if ($valign) { $attr .= ' valign="' . htmlspecialchars($valign) . '"'; }
        if (isset($this -> attrib['colspan'])) {
            $colspan = (int) $this -> attrib['colspan'];
            if ($colspan) {
                $attr .= ' colspan="' . $colspan . '"';
            }
        }
        if (isset($this -> attrib['rowspan'])) {
            $rowspan = (int) $this -> attrib['rowspan'];
            if ($rowspan) {
                $attr .= ' rowspan="' . $rowspan . '"';
            }
        }

        return '<td ' . $attr . '>' . parent::get_html($this -> tree) . '</td>';
    }
}
