<?php

/******************************************************************************
 *                                                                            *
 *   Code.php, v 0.06 2007/04/29 - This is part of xBB library                *
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

/* Класс для тегов подсветки синтаксиса и для тегов [code] и [pre] */
class Xbb_Tags_Code extends bbcode
{
    /* Число разрывов строк, которые должны быть игнорированы перед тегом */
    public $lbr = 0;
    /* Число разрывов строк, которые должны быть игнорированы после тега */
    public $rbr = 1;
    public $behaviour = 'pre';
    /* Альтернативные названия языков и их трансляция в обозначения GeSHi */
    public $lang_synonym = array(
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
    /* Объект GeSHi */
    private $_geshi;

    /* Конструктор класса */
    public function __construct()
    {
        $geshi_path = realpath(
            dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
            . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'geshi.php'
        );
        @include_once $geshi_path;
        $this->_geshi = new GeSHi('', 'text');
        $this->_geshi->set_header_type(GESHI_HEADER_NONE);
    }

    /* Описываем конвертацию в HTML */
    public function get_html($tree = null)
    {
        // Находим язык подсветки
        switch ($this->tag) {
            case 'code':
                $language = $this->attrib['code'];
                break;
            case 'pre':
                $language = $this->attrib['pre'];
                break;
            default:
                $language = $this->tag;
                break;
        }
        if (! $language) { $language = 'text'; }
        if (isset($this->lang_synonym[$language])) {
            $language = $this->lang_synonym[$language];
        }
        $this->_geshi->set_language($language);
        // Находим подсвечиваемый код
        $source = '';
        foreach ($this->tree as $item) {
            if ('item' === $item['type']) {
                continue;
            }
            $source .= $item['str'];
        }
        $this->_geshi->set_source($source);
        // Устанавливаем нумерацию строк
        if (isset($this->attrib['num'])) {
            $this->_geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
            if ('' !== $this -> attrib['num']) {
                $num = (int) $this->attrib['num'];
                $this->_geshi->start_line_numbers_at($num);
            }
        }
        // Задаем величину табуляции
        if (isset($this->attrib['tab'])) {
        	$this->attrib['tab'] = (int) $this->attrib['tab'];
        	if ($this->attrib['tab']) {
        	    $this->_geshi -> set_tab_width($this->attrib['tab']);
        	}
        }
        // Устанавливаем выделение строк
        if (isset($this->attrib['extra'])) {
            $extra = explode(',', $this->attrib['extra']);
            foreach ($extra as $key => $val) {
                $extra[$key] = (int) $val;
            }
            $this->_geshi->highlight_lines_extra($extra);
        }
        // Формируем заголовок
        $result = '<span class="bb_code_lang">'
            . $this->_geshi->get_language_name() . '</span>';
        if (isset($this->attrib['title'])) {
            $result = htmlspecialchars($this->attrib['title'], ENT_NOQUOTES);
        }
        // Получаем подсвеченный код
        $result = '<div class="bb_code"><div class="bb_code_header">' . $result
            . '</div>' . $this->_geshi->parse_code();
        // Формируем подпись под кодом
        if (isset($this->attrib['footer'])) {
            $content = htmlspecialchars($this->attrib['footer'], ENT_NOQUOTES);
            $content = '<div class="bb_code_footer">' . $content . '</div>';
            $result .= $content;
        }

        // Возвращаем результат
        return $result . '</div>';
    }
}
