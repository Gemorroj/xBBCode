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
 * Class Align
 * Класс для тегов [align], [center], [justify], [left] и [right]
 */
class Align extends Xbbcode
{
    public $rbr = 1;

    public function getHtml($tree = null)
    {
        $align = '';
        if (isset($this -> attrib['justify'])) { $align = 'justify'; }
        if (isset($this -> attrib['left'])) { $align = 'left'; }
        if (isset($this -> attrib['right'])) { $align = 'right'; }
        if (isset($this -> attrib['center'])) { $align = 'center'; }
        if (! $align && isset($this -> attrib['align'])) {
            switch (strtolower($this -> attrib['align'])) {
                case 'left':
                    $align = 'left';
                    break;
                case 'right':
                    $align = 'right';
                    break;
                case 'center':
                    $align = 'center';
                    break;
                case 'justify':
                    $align = 'justify';
                    break;
            }
        }

        return '<div class="bb" align="' . $align . '">'
            . parent::getHtml($this -> tree) . '</div>';
    }
}
