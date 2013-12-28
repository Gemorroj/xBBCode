<?php

/******************************************************************************
 *                                                                            *
 *   Email.php, v 0.00 2007/04/21 - This is part of xBB library               *
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

// Класс для тега [email]
class Email extends Xbbcode
{
    public $behaviour = 'a';

    public function getHtml($tree = null)
    {
        $this -> autolinks = false;
        $attr = ' class="bb_email"';
        $href = $this -> attrib['email'];
        if (! $href) {
            foreach ($this -> tree as $text) {
                if ('text' === $text['type']) {
                    $href .= $text['str'];
                }
            }
        }
        $protocols = array('mailto:');
        $is_http = false;
        foreach ($protocols as $val) {
            if ($val === substr($href, 0, strlen($val))) {
                $is_http = true;
                break;
            }
        }
        if (! $is_http) { $href = 'mailto:' . $href; }
        if ($href) { $attr .= ' href="' . htmlspecialchars($href) . '"'; }
        $title = isset($this -> attrib['title']) ? $this -> attrib['title'] : '';
        if ($title) { $attr .= ' title="' . htmlspecialchars($title) . '"'; }
        $name = isset($this -> attrib['name']) ? $this -> attrib['name'] : '';
        if ($name) { $attr .= ' name="' . htmlspecialchars($name) . '"'; }
        $target = isset($this -> attrib['target']) ? $this -> attrib['target'] : '';
        if ($target) { $attr .= ' target="' . htmlspecialchars($target) . '"'; }

        return '<a' . $attr . '>' . parent::getHtml($this -> tree) . '</a>';
    }
}
