<?php

/******************************************************************************
 *                                                                            *
 *   List.php, v 0.01 2007/04/29 - This is part of xBB library                *
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

// Класс для тегов [list], [ol], [ul]
class Ul extends Xbbcode
{
    public $lbr = 1;
    public $rbr = 1;
    public $behaviour = 'ul';

    public function getHtml($tree = null)
    {
        $tag_name = 'ul';
        $type = '';
        switch ($this->tag) {
            case 'ol':
                $tag_name = 'ol';
                $type = strtolower($this->attrib['ol']);
                break;
            case 'list':
                if ($this->attrib['list']) {
                    $tag_name = 'ol';
                }
                $type = strtolower($this->attrib['list']);
                $this->tag = 'del';
        }
        $attr = ' class="bb"';
        if ('1' === $type) {
            $attr .= ' type="1"';
        } elseif ($type) {
            $attr .= ' type="a"';
        }

        return '<' . $tag_name . $attr . '>' . parent::getHtml() . '</'
            . $tag_name . '>';
    }
}
