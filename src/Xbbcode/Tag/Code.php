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


/**
 * Class Code
 * Класс для тегов подсветки синтаксиса и для тегов [code] и [pre]
 */
class Code extends Tag
{
    //const BR_RIGHT = 1;
    const BEHAVIOUR = 'pre';

    /* Альтернативные названия языков и их трансляция в обозначения GeSHi */
    public $langSynonym = array(
        'algol'  => 'algol86',
        'c++'    => 'cpp',
        'c#'     => 'csharp',
        'f++'    => 'fsharp',
        'html'   => 'html4strict',
        'html4'  => 'html4strict',
        'js'     => 'javascript',
        'ocaml'  => 'ocaml-brief',
        'oracle' => 'oracle8',
        't-sql'  => 'tsql',
        'vb.net' => 'vbnet',
    );
    /**
     * @var \GeSHi
     */
    protected $geshi;

    /* Конструктор класса */
    public function __construct()
    {
        parent::__construct();
        $this->geshi = new \GeSHi('', 'text');
        $this->geshi->set_header_type(GESHI_HEADER_NONE);
    }

    /**
     * Язык для подсветки
     *
     * @return Code
     */
    protected function setLanguage()
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
     * Подсвечиваемый код
     *
     * @return Code
     */
    protected function setSource()
    {
        $this->geshi->set_source($this->getTreeText());

        return $this;
    }

    /**
     * Ссылки на документацию
     *
     * @return Code
     */
    protected function setLinks()
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
     * Нумерация строк
     *
     * @return Code
     */
    protected function setNum()
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
     * Величина табуляции
     *
     * @return Code
     */
    protected function setTab()
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
     * Выделение строк
     *
     * @return Code
     */
    protected function setExtra()
    {
        if (isset($this->attributes['extra'])) {
            $extra = explode(',', $this->attributes['extra']);
            $this->geshi->highlight_lines_extra($extra);
        }

        return $this;
    }

    /**
     * Получаем заголовок
     *
     * @return string
     */
    protected function getHeader()
    {
        if (isset($this->attributes['title'])) {
            $title = $this->attributes['title'];
        } else {
            $title = $this->geshi->get_language_name();
        }

        return '<div class="bb_code_header"><span class="bb_code_lang">' . htmlspecialchars($title, ENT_NOQUOTES) . '</span></div>';

    }


    /**
     * Получаем подвал
     *
     * @return string
     */
    protected function getFooter()
    {
        if (isset($this->attributes['footer'])) {
            return '<div class="bb_code_footer">' . htmlspecialchars($this->attributes['footer'], ENT_NOQUOTES) . '</div>';
        }

        return '';
    }

    /**
     * Return html code
     *
     * @return string
     */
    public function __toString()
    {
        $this->setLanguage();
        $this->setSource();
        $this->setNum();
        $this->setTab();
        $this->setExtra();
        $this->setLinks();

        return '<div class="bb_code">' . $this->getHeader() . $this->geshi->parse_code() . $this->getFooter() . '</div>';
    }
}
