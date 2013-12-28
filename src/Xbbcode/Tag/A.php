<?php

/******************************************************************************
 *                                                                            *
 *   A.php, v 0.00 2007/04/21 - This is part of xBB library                   *
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

// Класс для тегов [a], [anchor] и [url]
class A extends Xbbcode
{
    public $behaviour = 'a';

    public function get_html($tree = null)
    {
        $this -> autolinks = false;
        $text = '';
        foreach ($this -> tree as $val) {
            if ('text' === $val['type']) {
                $text .= $val['str'];
            }
        }
        $href = '';
        if (isset($this -> attrib['url'])) {
            $href = $this -> attrib['url'];
        }
        if (! $href && isset($this -> attrib['a'])) {
            $href = $this -> attrib['a'];
        }
        if (! $href && isset($this -> attrib['href'])) {
            $href = $this -> attrib['href'];
        }
        if (! $href && ! isset($this -> attrib['anchor'])) {
            $href = $text;
        }

        $href = $this -> _checkUrl($href);

        $attr = 'class="bb"';
        if ($href) {
            $attr .= ' href="' . $href . '"';
        }
        if (isset($this -> attrib['title'])) {
            $title = $this -> attrib['title'];
            $attr .= ' title="' . htmlspecialchars($title) . '"';
        }
        $id = '';
        if (isset($this -> attrib['id'])) {
            $id = $this -> attrib['id'];
        }
        if (! $id && isset($this -> attrib['name'])) {
            $id = $this -> attrib['name'];
        }
        if (! $id && isset($this -> attrib['anchor'])) {
            $id = $this -> attrib['anchor'];
            if (! $id) { $id = $text; }
        }
        if ($id) {
            if ($id{0} < 'A' || $id{0} > 'z') {
                $id = 'bb' . $id;
            }
            $attr .= ' id="' . htmlspecialchars($id) . '"';
        }
        if (isset($this -> attrib['target'])) {
            $target = $this -> attrib['target'];
            $attr .= ' target="' . htmlspecialchars($target) . '"';
        }

        return '<a ' . $attr . '>' . parent::get_html($this -> tree) . '</a>';
    }
}
