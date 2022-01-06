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
 * Class Bdo
 * Класс для тега [bdo].
 */
class Bdo extends Tag
{
    public const BEHAVIOUR = 'span';

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = parent::getAttributes();

        $dir = '';
        switch (\strtolower($this->attributes['bdo'])) {
            case 'ltr':
                $dir = 'ltr';
                break;
            case 'rtl':
                $dir = 'rtl';
                break;
        }
        if ($dir) {
            $attr->set('dir', $dir);
        }

        if (isset($this->attributes['lang'])) {
            $attr->set('lang', $this->attributes['lang']);
        }

        if (isset($this->attributes['title'])) {
            $attr->set('title', $this->attributes['title']);
        }

        return $attr;
    }

    /**
     * Return html code.
     */
    public function __toString(): string
    {
        return '<bdo '.$this->getAttributes().'>'.$this->getBody().'</bdo>';
    }
}
