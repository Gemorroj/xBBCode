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

use Xbbcode\Attributes;


/**
 * Class A
 * Класс для тегов [a], [anchor] и [url]
 */
class A extends Tag
{
    public $behaviour = 'a';
    public $autolinks = false;


    /**
     * @return string
     */
    protected function getHref()
    {
        $text = '';
        foreach ($this->tree as $val) {
            if ('text' === $val['type']) {
                $text .= $val['str'];
            }
        }

        $href = '';
        if (isset($this->attributes['url'])) {
            $href = $this->attributes['url'];
        }
        if (!$href && isset($this->attributes['a'])) {
            $href = $this->attributes['a'];
        }
        if (!$href && isset($this->attributes['href'])) {
            $href = $this->attributes['href'];
        }
        if (!$href && isset($this->attributes['anchor'])) {
            $href = $this->attributes['anchor'];
        }
        if (!$href) {
            $href = $text;
        }

        return $this->parseUrl($href);
    }

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = new Attributes();

        $href = $this->getHref();
        if ($href) {
            $attr->set('href', $href);
        }

        if (isset($this->attributes['title'])) {
            $attr->set('title', $this->attributes['title']);
        }

        if (isset($this->attributes['target'])) {
            if ($this->isValidTarget($this->attributes['target'])) {
                $attr->set('target', $this->attributes['target']);
            }
        }

        return $attr;
    }


    /**
     * Return html code
     *
     * @return string
     */
    public function __toString()
    {
        return '<a ' . $this->getAttributes() . '>' . $this->getBody() . '</a>';
    }
}
