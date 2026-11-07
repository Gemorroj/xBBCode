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
 * Spoiler tag rendered as native HTML <details>/<summary>.
 *
 * Unlike the legacy Spoiler handler, this implementation does not use inline
 * JavaScript or hidden style attributes, so it survives HTML sanitizers and
 * Content Security Policy restrictions.
 */
class SpoilerDetails extends TagAbstract
{
    public string $showButton = 'Показать';
    public string $hideButton = 'Скрыть';

    protected function getAttributes(): Attributes
    {
        return new Attributes();
    }

    public function __toString(): string
    {
        return '<details class="bb_spoiler"><summary><span class="bb_spoiler_show">'.\htmlspecialchars(
            $this->showButton,
            \ENT_QUOTES
        ).'</span><span class="bb_spoiler_hide" hidden>'.\htmlspecialchars(
            $this->hideButton,
            \ENT_QUOTES
        ).'</span></summary>'.$this->getBody().'</details>';
    }
}
