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
 * Class Spoiler
 * Класс для тегов [spoiler] и [hide]
 */
class Spoiler extends Tag
{
    public $showButton = 'Показать';
    public $hideButton = 'Скрыть';

    /**
     * @param string $id
     * @return string
     */
    protected function getSpoiler($id)
    {
        return '<input class="bb_spoiler" type="button" value="' . htmlspecialchars(
            $this->showButton
        ) . '" onclick="var node = document.getElementById(\'' . $id . '\'); (node.style.display == \'none\' ? (node.style.display = \'block\', this.value = \'' . htmlspecialchars(
            $this->hideButton,
            ENT_QUOTES
        ) . '\') : (node.style.display = \'none\', this.value = \'' . htmlspecialchars(
            $this->showButton,
            ENT_QUOTES
        ) . '\'));" />';
    }

    /**
     * @return Attributes
     */
    protected function getAttributes()
    {
        $attr = parent::getAttributes();

        $attr->add('class', 'bb_spoiler');
        $attr->set('style', 'display: none');

        $id = uniqid('xbbcode');
        $attr->set('id', $id);

        return $attr;
    }

    /**
     * Return html code
     *
     * @return string
     */
    public function __toString()
    {
        $attr = $this->getAttributes();
        $id = $attr->getAttributeValue('id');

        return $this->getSpoiler($id) . '<div ' . $attr . '>' . $this->getBody() . '</div>';
    }
}
