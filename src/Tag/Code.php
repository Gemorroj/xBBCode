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
 * Class Code
 * Класс для тегов подсветки синтаксиса и для тегов [code] и [pre].
 */
class Code extends TagAbstract
{
    public const BEHAVIOUR = 'pre';

    /**
     * Альтернативные названия языков и их трансляция в обозначения GeSHi.
     *
     * @var array<string, string>
     */
    public array $langSynonym = [
        'algol' => 'algol86',
        'c++' => 'cpp',
        'c#' => 'csharp',
        'f++' => 'fsharp',
        'html' => 'html4strict',
        'html4' => 'html4strict',
        'js' => 'javascript',
        'ocaml' => 'ocaml-brief',
        'oracle' => 'oracle8',
        't-sql' => 'tsql',
        'vb.net' => 'vbnet',
    ];

    protected \GeSHi $geshi;

    public function __construct()
    {
        parent::__construct();
        $this->geshi = new \GeSHi();
        $this->geshi->set_header_type(GESHI_HEADER_NONE);
    }

    protected function getAttributes(): Attributes
    {
        return new Attributes();
    }

    /**
     * Язык для подсветки.
     */
    protected function setLanguage(): self
    {
        switch ($this->getTagName()) {
            case 'code':
                $language = $this->attributes['code'];
                break;
            case 'pre':
                $language = $this->attributes['pre'];
                break;
            default:
                $language = $this->getTagName();
                break;
        }

        if (!$language) {
            $language = 'text';
        }

        if (isset($this->langSynonym[$language])) {
            $language = $this->langSynonym[$language];
        }

        $this->geshi->set_language($language);

        return $this;
    }

    /**
     * Подсвечиваемый код.
     */
    protected function setSource(): self
    {
        $this->geshi->set_source($this->getTreeText());

        return $this;
    }

    /**
     * Ссылки на документацию.
     */
    protected function setLinks(): self
    {
        if (isset($this->attributes['links'])) {
            if ('1' === $this->attributes['links'] || 'true' === $this->attributes['links']) {
                $this->geshi->enable_keyword_links(true);
            } else {
                $this->geshi->enable_keyword_links(false);
            }
        } else {
            $this->geshi->enable_keyword_links($this->getKeywordLinks());
        }

        return $this;
    }

    /**
     * Нумерация строк.
     */
    protected function setNum(): self
    {
        if (isset($this->attributes['num'])) {
            $this->geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
            if ('' !== $this->attributes['num']) {
                $num = (int) $this->attributes['num'];
                $this->geshi->start_line_numbers_at($num);
            }
        }

        return $this;
    }

    /**
     * Величина табуляции.
     */
    protected function setTab(): self
    {
        if (isset($this->attributes['tab'])) {
            $this->attributes['tab'] = (int) $this->attributes['tab'];
            if ($this->attributes['tab']) {
                $this->geshi->set_tab_width($this->attributes['tab']);
            }
        }

        return $this;
    }

    /**
     * Выделение строк.
     */
    protected function setExtra(): self
    {
        if (isset($this->attributes['extra'])) {
            $extra = \explode(',', $this->attributes['extra']);
            $this->geshi->highlight_lines_extra($extra);
        }

        return $this;
    }

    /**
     * Получаем заголовок.
     */
    protected function getHeader(): string
    {
        $title = $this->attributes['title'] ?? $this->geshi->get_language_name();

        return '<div class="bb_code_header"><span class="bb_code_lang">'.\htmlspecialchars($title, \ENT_NOQUOTES).'</span></div>';
    }

    /**
     * Получаем подвал.
     */
    protected function getFooter(): string
    {
        if (isset($this->attributes['footer'])) {
            return '<div class="bb_code_footer">'.\htmlspecialchars($this->attributes['footer'], \ENT_NOQUOTES).'</div>';
        }

        return '';
    }

    /**
     * Return html code.
     */
    public function __toString(): string
    {
        $this->setLanguage();
        $this->setSource();
        $this->setNum();
        $this->setTab();
        $this->setExtra();
        $this->setLinks();

        $result = $this->geshi->parse_code();
        $result = \str_replace('&nbsp;', '&#160;', $result);

        return '<div class="bb_code">'.$this->getHeader().'<code class="bb_code">'.$result.'</code>'.$this->getFooter().'</div>';
    }
}
