<?php

/******************************************************************************
 *                                                                            *
 *   Table.php, v 0.00 2007/04/21 - This is part of xBB library               *
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

// Класс для тега [table]
class Xbb_Tags_Table extends bbcode
{
    public $rbr = 1;
    public $behaviour = 'table';

    public function get_html($tree = null)
    {
        $attr = ' class="bb"';
        $border = isset($this -> attrib['border'])
            ? (int) $this -> attrib['border']
            : null;
        if (null !== $border) { $attr .= ' border="' . $border . '"'; }
        $width = isset($this -> attrib['width']) ? $this -> attrib['width'] : '';
        if ($width) { $attr .= ' width="' . htmlspecialchars($width) . '"'; }
        $cellspacing = isset($this -> attrib['cellspacing'])
            ? (int) $this -> attrib['cellspacing']
            : null;
        if (null !== $cellspacing) { $attr .= ' cellspacing="' . $cellspacing . '"'; }
        $cellpadding = isset($this -> attrib['cellpadding'])
            ? (int) $this -> attrib['cellpadding']
            : null;
        if (null !== $cellpadding) { $attr .= ' cellpadding="' . $cellpadding . '"'; }
        $align = isset($this -> attrib['align']) ? $this -> attrib['align'] : '';
        if ($align) { $attr .= ' align="' . htmlspecialchars($align) . '"'; }
        $str = '<table' . $attr . '>';
        foreach ($this -> tree as $key => $item) {
            if ('text' === $item['type']) {
                unset($this -> tree[$key]);
            }
        }
        $str .= parent::get_html($this -> tree) . '</table>';

        return $str;
    }
}
