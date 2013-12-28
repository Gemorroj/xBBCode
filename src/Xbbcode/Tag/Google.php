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
 * Class Google
 * Класс для тега [google]
 */
class Google extends Xbbcode
{
    public $behaviour = 'a';

    public function getHtml($tree = null)
    {
        $q = isset($this -> attrib['q']) ? $this -> attrib['q'] : '';
        if (!$q) {
            foreach ($this -> tree as $val) {
                if ('text' === $val['type']) {
                    $q .= $val['str'];
                }
            }
        }

        $attr = ' href="http://www.google.com/search?q=' . rawurlencode($q) . '"';

        $title = isset($this -> attrib['title']) ? $this -> attrib['title'] : '';
        if ($title) { $attr .= ' title="' . $this->htmlspecialchars($title) . '"'; }

        $name = isset($this -> attrib['name']) ? $this -> attrib['name'] : '';
        if ($name) { $attr .= ' name="' . $this->htmlspecialchars($name) . '"'; }

        $target = isset($this -> attrib['target']) ? $this -> attrib['target'] : '';
        if ($target) { $attr .= ' target="' . $this->htmlspecialchars($target) . '"'; }

        return '<a class="bb_google" ' . $attr . '>' . parent::getHtml($this -> tree) . '</a>';
    }
}
