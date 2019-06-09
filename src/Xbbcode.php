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

namespace Xbbcode;

use Xbbcode\Tag\Tag;

/**
 * Class Xbbcode
 */
class Xbbcode
{
    /**
     * Имя тега, которому сопоставлен экземпляр класса.
     * Пустая строка, если экземпляр не сопоставлен никакому тегу.
     *
     * @var string
     */
    protected $tagName = '';
    /**
     * Текст BBCode
     *
     * @var string
     */
    protected $text = '';
    /**
     * Массив, - результат синтаксического разбора текста BBCode. Описание смотрите в документации.
     *
     * @var array
     */
    protected $syntax = [];
    /**
     * Дерево семантического разбора текста BBCode. Описание смотрите в документации.
     *
     * @var array
     */
    protected $tree = [];
    /**
     * Список поддерживаемых тегов с указанием специализированных классов.
     *
     * @var string[]
     */
    protected $tags = [
        // Основные теги
        '*'            => 'Xbbcode\Tag\Li'     ,
        'a'            => 'Xbbcode\Tag\A'      ,
        'abbr'         => 'Xbbcode\Tag\Abbr'   ,
        'acronym'      => 'Xbbcode\Tag\Acronym',
        'address'      => 'Xbbcode\Tag\Address',
        'align'        => 'Xbbcode\Tag\Align'  ,
        'anchor'       => 'Xbbcode\Tag\A'      ,
        'b'            => 'Xbbcode\Tag\Simple' ,
        'bbcode'       => 'Xbbcode\Tag\Bbcode' ,
        'bdo'          => 'Xbbcode\Tag\Bdo'    ,
        'big'          => 'Xbbcode\Tag\Simple' ,
        'blockquote'   => 'Xbbcode\Tag\Quote'  ,
        'br'           => 'Xbbcode\Tag\Br'     ,
        'caption'      => 'Xbbcode\Tag\Caption',
        'center'       => 'Xbbcode\Tag\Align'  ,
        'cite'         => 'Xbbcode\Tag\Simple' ,
        'color'        => 'Xbbcode\Tag\Color'  ,
        'del'          => 'Xbbcode\Tag\Simple' ,
        'em'           => 'Xbbcode\Tag\Simple' ,
        'email'        => 'Xbbcode\Tag\Email'  ,
        'font'         => 'Xbbcode\Tag\Font'   ,
        'altfont'      => 'Xbbcode\Tag\Altfont',
        'google'       => 'Xbbcode\Tag\Google' ,
        'yandex'       => 'Xbbcode\Tag\Yandex' ,
        'youtube'      => 'Xbbcode\Tag\Youtube',
        'spoiler'      => 'Xbbcode\Tag\Spoiler',
        'hide'         => 'Xbbcode\Tag\Spoiler',
        'h1'           => 'Xbbcode\Tag\P'      ,
        'h2'           => 'Xbbcode\Tag\P'      ,
        'h3'           => 'Xbbcode\Tag\P'      ,
        'h4'           => 'Xbbcode\Tag\P'      ,
        'h5'           => 'Xbbcode\Tag\P'      ,
        'h6'           => 'Xbbcode\Tag\P'      ,
        'hr'           => 'Xbbcode\Tag\Hr'     ,
        'i'            => 'Xbbcode\Tag\Simple' ,
        'img'          => 'Xbbcode\Tag\Img'    ,
        'ins'          => 'Xbbcode\Tag\Simple' ,
        'justify'      => 'Xbbcode\Tag\Align'  ,
        'left'         => 'Xbbcode\Tag\Align'  ,
        'li'           => 'Xbbcode\Tag\Li'     ,
        'list'         => 'Xbbcode\Tag\Ul'     ,
        'nobb'         => 'Xbbcode\Tag\Nobb'   ,
        'ol'           => 'Xbbcode\Tag\Ol'     ,
        'p'            => 'Xbbcode\Tag\P'      ,
        'quote'        => 'Xbbcode\Tag\Quote'  ,
        'right'        => 'Xbbcode\Tag\Align'  ,
        's'            => 'Xbbcode\Tag\Simple' ,
        'size'         => 'Xbbcode\Tag\Size'   ,
        'small'        => 'Xbbcode\Tag\Simple' ,
        'strike'       => 'Xbbcode\Tag\Simple' ,
        'strong'       => 'Xbbcode\Tag\Simple' ,
        'sub'          => 'Xbbcode\Tag\Simple' ,
        'sup'          => 'Xbbcode\Tag\Simple' ,
        'table'        => 'Xbbcode\Tag\Table'  ,
        'td'           => 'Xbbcode\Tag\Td'     ,
        'th'           => 'Xbbcode\Tag\Th'     ,
        'tr'           => 'Xbbcode\Tag\Tr'     ,
        'tt'           => 'Xbbcode\Tag\Simple' ,
        'u'            => 'Xbbcode\Tag\Simple' ,
        'ul'           => 'Xbbcode\Tag\Ul'     ,
        'url'          => 'Xbbcode\Tag\A'      ,
        'var'          => 'Xbbcode\Tag\Simple' ,

        // Теги для вывода кода и подсветки синтаксисов (с помощью GeSHi)
        '4cs'               => 'Xbbcode\Tag\Code',
        '6502acme'          => 'Xbbcode\Tag\Code',
        '6502kickass'       => 'Xbbcode\Tag\Code',
        '6502tasm'          => 'Xbbcode\Tag\Code',
        '68000devpac'       => 'Xbbcode\Tag\Code',
        'abap'              => 'Xbbcode\Tag\Code',
        'actionscript'      => 'Xbbcode\Tag\Code',
        'actionscript3'     => 'Xbbcode\Tag\Code',
        'ada'               => 'Xbbcode\Tag\Code',
        'algol'             => 'Xbbcode\Tag\Code',
        'apache'            => 'Xbbcode\Tag\Code',
        'applescript'       => 'Xbbcode\Tag\Code',
        'apt_sources'       => 'Xbbcode\Tag\Code',
        'arm'               => 'Xbbcode\Tag\Code',
        'asm'               => 'Xbbcode\Tag\Code',
        'asp'               => 'Xbbcode\Tag\Code',
        'asymptote'         => 'Xbbcode\Tag\Code',
        'autoconf'          => 'Xbbcode\Tag\Code',
        'autohotkey'        => 'Xbbcode\Tag\Code',
        'autoit'            => 'Xbbcode\Tag\Code',
        'avisynth'          => 'Xbbcode\Tag\Code',
        'awk'               => 'Xbbcode\Tag\Code',
        'bascomavr'         => 'Xbbcode\Tag\Code',
        'bash'              => 'Xbbcode\Tag\Code',
        'basic4gl'          => 'Xbbcode\Tag\Code',
        'bf'                => 'Xbbcode\Tag\Code',
        'bibtex'            => 'Xbbcode\Tag\Code',
        'blitzbasic'        => 'Xbbcode\Tag\Code',
        'bnf'               => 'Xbbcode\Tag\Code',
        'boo'               => 'Xbbcode\Tag\Code',
        'c'                 => 'Xbbcode\Tag\Code',
        'c++'               => 'Xbbcode\Tag\Code',
        'c#'                => 'Xbbcode\Tag\Code',
        'c_loadrunner'      => 'Xbbcode\Tag\Code',
        'c_mac'             => 'Xbbcode\Tag\Code',
        'caddcl'            => 'Xbbcode\Tag\Code',
        'cadlisp'           => 'Xbbcode\Tag\Code',
        'cfdg'              => 'Xbbcode\Tag\Code',
        'cfm'               => 'Xbbcode\Tag\Code',
        'chaiscript'        => 'Xbbcode\Tag\Code',
        'cil'               => 'Xbbcode\Tag\Code',
        'clojure'           => 'Xbbcode\Tag\Code',
        'cmake'             => 'Xbbcode\Tag\Code',
        'cobol'             => 'Xbbcode\Tag\Code',
        'code'              => 'Xbbcode\Tag\Code',
        'coffeescript'      => 'Xbbcode\Tag\Code',
        'cpp-qt'            => 'Xbbcode\Tag\Code',
        'css'               => 'Xbbcode\Tag\Code',
        'cuesheet'          => 'Xbbcode\Tag\Code',
        'd'                 => 'Xbbcode\Tag\Code',
        'dcl'               => 'Xbbcode\Tag\Code',
        'dcpu16'            => 'Xbbcode\Tag\Code',
        'dcs'               => 'Xbbcode\Tag\Code',
        'delphi'            => 'Xbbcode\Tag\Code',
        'diff'              => 'Xbbcode\Tag\Code',
        'div'               => 'Xbbcode\Tag\Code',
        'dos'               => 'Xbbcode\Tag\Code',
        'e'                 => 'Xbbcode\Tag\Code',
        'ecmascript'        => 'Xbbcode\Tag\Code',
        'eiffel'            => 'Xbbcode\Tag\Code',
        'epc'               => 'Xbbcode\Tag\Code',
        'erlang'            => 'Xbbcode\Tag\Code',
        'euphoria'          => 'Xbbcode\Tag\Code',
        'f++'               => 'Xbbcode\Tag\Code',
        'f#'                => 'Xbbcode\Tag\Code',
        'f1'                => 'Xbbcode\Tag\Code',
        'falcon'            => 'Xbbcode\Tag\Code',
        'fo'                => 'Xbbcode\Tag\Code',
        'fortran'           => 'Xbbcode\Tag\Code',
        'freebasic'         => 'Xbbcode\Tag\Code',
        'freeswitch'        => 'Xbbcode\Tag\Code',
        'gambas'            => 'Xbbcode\Tag\Code',
        'gdb'               => 'Xbbcode\Tag\Code',
        'genero'            => 'Xbbcode\Tag\Code',
        'genie'             => 'Xbbcode\Tag\Code',
        'gettext'           => 'Xbbcode\Tag\Code',
        'glsl'              => 'Xbbcode\Tag\Code',
        'gml'               => 'Xbbcode\Tag\Code',
        'gnuplot'           => 'Xbbcode\Tag\Code',
        'go'                => 'Xbbcode\Tag\Code',
        'groovy'            => 'Xbbcode\Tag\Code',
        'gwbasic'           => 'Xbbcode\Tag\Code',
        'haskell'           => 'Xbbcode\Tag\Code',
        'haxe'              => 'Xbbcode\Tag\Code',
        'hicest'            => 'Xbbcode\Tag\Code',
        'hq9plus'           => 'Xbbcode\Tag\Code',
        'html4'             => 'Xbbcode\Tag\Code',
        'html5'             => 'Xbbcode\Tag\Code',
        'icon'              => 'Xbbcode\Tag\Code',
        'idl'               => 'Xbbcode\Tag\Code',
        'ini'               => 'Xbbcode\Tag\Code',
        'inno'              => 'Xbbcode\Tag\Code',
        'intercal'          => 'Xbbcode\Tag\Code',
        'io'                => 'Xbbcode\Tag\Code',
        'j'                 => 'Xbbcode\Tag\Code',
        'java'              => 'Xbbcode\Tag\Code',
        'java5'             => 'Xbbcode\Tag\Code',
        'jquery'            => 'Xbbcode\Tag\Code',
        'js'                => 'Xbbcode\Tag\Code',
        'kixtart'           => 'Xbbcode\Tag\Code',
        'klonec'            => 'Xbbcode\Tag\Code',
        'klonecpp'          => 'Xbbcode\Tag\Code',
        'latex'             => 'Xbbcode\Tag\Code',
        'lb'                => 'Xbbcode\Tag\Code',
        'ldif'              => 'Xbbcode\Tag\Code',
        'lisp'              => 'Xbbcode\Tag\Code',
        'llvm'              => 'Xbbcode\Tag\Code',
        'locobasic'         => 'Xbbcode\Tag\Code',
        'logtalk'           => 'Xbbcode\Tag\Code',
        'lolcode'           => 'Xbbcode\Tag\Code',
        'lotusformulas'     => 'Xbbcode\Tag\Code',
        'lotusscript'       => 'Xbbcode\Tag\Code',
        'lscript'           => 'Xbbcode\Tag\Code',
        'lsl2'              => 'Xbbcode\Tag\Code',
        'lua'               => 'Xbbcode\Tag\Code',
        'm68k'              => 'Xbbcode\Tag\Code',
        'magiksf'           => 'Xbbcode\Tag\Code',
        'make'              => 'Xbbcode\Tag\Code',
        'mapbasic'          => 'Xbbcode\Tag\Code',
        'matlab'            => 'Xbbcode\Tag\Code',
        'mirc'              => 'Xbbcode\Tag\Code',
        'mmix'              => 'Xbbcode\Tag\Code',
        'modula2'           => 'Xbbcode\Tag\Code',
        'modula3'           => 'Xbbcode\Tag\Code',
        'mpasm'             => 'Xbbcode\Tag\Code',
        'mxml'              => 'Xbbcode\Tag\Code',
        'mysql'             => 'Xbbcode\Tag\Code',
        'nagios'            => 'Xbbcode\Tag\Code',
        'netrexx'           => 'Xbbcode\Tag\Code',
        'newlisp'           => 'Xbbcode\Tag\Code',
        'nsis'              => 'Xbbcode\Tag\Code',
        'oberon2'           => 'Xbbcode\Tag\Code',
        'objc'              => 'Xbbcode\Tag\Code',
        'objeck'            => 'Xbbcode\Tag\Code',
        'ocaml'             => 'Xbbcode\Tag\Code',
        'octave'            => 'Xbbcode\Tag\Code',
        'oobas'             => 'Xbbcode\Tag\Code',
        'oorexx'            => 'Xbbcode\Tag\Code',
        'oracle'            => 'Xbbcode\Tag\Code',
        'oracle11'          => 'Xbbcode\Tag\Code',
        'oxygene'           => 'Xbbcode\Tag\Code',
        'oz'                => 'Xbbcode\Tag\Code',
        'parasail'          => 'Xbbcode\Tag\Code',
        'parigp'            => 'Xbbcode\Tag\Code',
        'pascal'            => 'Xbbcode\Tag\Code',
        'pcre'              => 'Xbbcode\Tag\Code',
        'per'               => 'Xbbcode\Tag\Code',
        'perl'              => 'Xbbcode\Tag\Code',
        'perl6'             => 'Xbbcode\Tag\Code',
        'pf'                => 'Xbbcode\Tag\Code',
        'php'               => 'Xbbcode\Tag\Code',
        'pic16'             => 'Xbbcode\Tag\Code',
        'pike'              => 'Xbbcode\Tag\Code',
        'pixelbender'       => 'Xbbcode\Tag\Code',
        'pli'               => 'Xbbcode\Tag\Code',
        'plsql'             => 'Xbbcode\Tag\Code',
        'postgresql'        => 'Xbbcode\Tag\Code',
        'povray'            => 'Xbbcode\Tag\Code',
        'powershell'        => 'Xbbcode\Tag\Code',
        'pre'               => 'Xbbcode\Tag\Code',
        'proftpd'           => 'Xbbcode\Tag\Code',
        'progress'          => 'Xbbcode\Tag\Code',
        'prolog'            => 'Xbbcode\Tag\Code',
        'properties'        => 'Xbbcode\Tag\Code',
        'providex'          => 'Xbbcode\Tag\Code',
        'purebasic'         => 'Xbbcode\Tag\Code',
        'pycon'             => 'Xbbcode\Tag\Code',
        'pys60'             => 'Xbbcode\Tag\Code',
        'python'            => 'Xbbcode\Tag\Code',
        'q'                 => 'Xbbcode\Tag\Code',
        'qbasic'            => 'Xbbcode\Tag\Code',
        'rails'             => 'Xbbcode\Tag\Code',
        'rebol'             => 'Xbbcode\Tag\Code',
        'reg'               => 'Xbbcode\Tag\Code',
        'rexx'              => 'Xbbcode\Tag\Code',
        'robots'            => 'Xbbcode\Tag\Code',
        'rpmspec'           => 'Xbbcode\Tag\Code',
        'rsplus'            => 'Xbbcode\Tag\Code',
        'ruby'              => 'Xbbcode\Tag\Code',
        'sas'               => 'Xbbcode\Tag\Code',
        'scala'             => 'Xbbcode\Tag\Code',
        'scheme'            => 'Xbbcode\Tag\Code',
        'scilab'            => 'Xbbcode\Tag\Code',
        'sdlbasic'          => 'Xbbcode\Tag\Code',
        'smalltalk'         => 'Xbbcode\Tag\Code',
        'smarty'            => 'Xbbcode\Tag\Code',
        'spark'             => 'Xbbcode\Tag\Code',
        'sparql'            => 'Xbbcode\Tag\Code',
        'sql'               => 'Xbbcode\Tag\Code',
        'stonescript'       => 'Xbbcode\Tag\Code',
        'systemverilog'     => 'Xbbcode\Tag\Code',
        't-sql'             => 'Xbbcode\Tag\Code',
        'tcl'               => 'Xbbcode\Tag\Code',
        'teraterm'          => 'Xbbcode\Tag\Code',
        'text'              => 'Xbbcode\Tag\Code',
        'thinbasic'         => 'Xbbcode\Tag\Code',
        'twig'              => 'Xbbcode\Tag\Code',
        'typoscript'        => 'Xbbcode\Tag\Code',
        'unicon'            => 'Xbbcode\Tag\Code',
        'upc'               => 'Xbbcode\Tag\Code',
        'urbi'              => 'Xbbcode\Tag\Code',
        'uscript'           => 'Xbbcode\Tag\Code',
        'vala'              => 'Xbbcode\Tag\Code',
        'vb'                => 'Xbbcode\Tag\Code',
        'vb.net'            => 'Xbbcode\Tag\Code',
        'vedit'             => 'Xbbcode\Tag\Code',
        'verilog'           => 'Xbbcode\Tag\Code',
        'vhdl'              => 'Xbbcode\Tag\Code',
        'vim'               => 'Xbbcode\Tag\Code',
        'visualfoxpro'      => 'Xbbcode\Tag\Code',
        'visualprolog'      => 'Xbbcode\Tag\Code',
        'whitespace'        => 'Xbbcode\Tag\Code',
        'whois'             => 'Xbbcode\Tag\Code',
        'winbatch'          => 'Xbbcode\Tag\Code',
        'xbasic'            => 'Xbbcode\Tag\Code',
        'xml'               => 'Xbbcode\Tag\Code',
        'xorg_conf'         => 'Xbbcode\Tag\Code',
        'xpp'               => 'Xbbcode\Tag\Code',
        'yaml'              => 'Xbbcode\Tag\Code',
        'z80'               => 'Xbbcode\Tag\Code',
        'zxbasic'           => 'Xbbcode\Tag\Code',
    ];
    /**
     * Смайлики и прочие мнемоники. Массив: 'мнемоника' => 'ее_замена'.
     *
     * @var array
     */
    protected $mnemonics = [];
    /**
     * Флажок, включающий/выключающий автоматические ссылки.
     *
     * @var bool
     */
    protected $autoLinks = false;
    /**
     * Массив замен для автоматических ссылок.
     *
     * @var array
     */
    protected $pregAutoLinks = [
        'pattern' => [
            "'[\w\+]+://[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+'si",
            "'([^/])(www\.[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+)'si",
            "'[\w]+[\w\-\.]+@[\w\-\.]+\.[\w]+'si",
        ],
        'replacement' => [
            '<a href="$0" target="_blank">$0</a>',
            '$1<a href="http://$2" target="_blank">$2</a>',
            '<a href="mailto:$0">$0</a>',
        ],
        'highlight' => [
            '<span class="bb_autolink">$0</span>',
            '$1<span class="bb_autolink">$2</span>',
            '<span class="bb_autolink">$0</span>',
        ],
    ];
    /**
     * Флажок, включающий/выключающий ссылки на документацию в подсветке кода.
     *
     * @var bool
     */
    protected $keywordLinks = false;

    /**
     * Флажок, включающий/выключающий подстановку смайлов.
     *
     * @var bool
     */
    protected $enableSmiles = true;

    /**
     * Статистические сведения по обработке BBCode
     *
     * @var array
     */
    protected $statistics = [
        'time_parse'        => 0, // Время парсинга
        'time_html'         => 0, // Время генерации HTML-а
        'count_tags'        => 0, // Число тегов BBCode
        'count_level'       => 0, // Число уровней вложенности тегов BBCode
        'memory_peak_usage' => 0, // Максимально выделенный объем памяти
    ];
    /**
     * Публичная WEB директория.
     * Ссылается на директорию resources для формирования смайликов и CSS стилей
     *
     * @var string
     */
    protected $webPath = '';
    /**
     * Для нужд парсера. - Позиция очередного обрабатываемого символа.
     *
     * @var int
     */
    private $cursor = 0;
    /**
     * Массив объектов, - представителей отдельных тегов.
     *
     * @var Tag[]
     */
    private $tagObjects = [];
    /**
     * Массив пар: 'модель_поведения_тегов' => массив_моделей_поведений_тегов.
     * Накладывает ограничения на вложенность тегов.
     * Теги с моделями поведения, не указанными в массиве справа, вложенные в тег с моделью поведения, указанной слева, будут игнорироваться как неправильно вложенные.
     *
     * @var array
     */
    protected $children = [
        'a'       => ['code', 'img', 'span'],
        'caption' => ['a', 'code', 'img', 'span'],
        'code'    => [],
        'div'     => ['a', 'code', 'div', 'hr', 'img', 'p', 'pre', 'span', 'table', 'ul'],
        'hr'      => [],
        'img'     => [],
        'li'      => ['a', 'code', 'div', 'hr', 'img', 'p', 'pre', 'span', 'table', 'ul'],
        'p'       => ['a', 'code', 'img', 'span'],
        'pre'     => [],
        'span'    => ['a', 'code', 'img', 'span'],
        'table'   => ['caption', 'tr'],
        'td'      => ['a', 'code', 'div', 'hr', 'img', 'p', 'pre', 'span', 'table', 'ul'],
        'tr'      => ['td'],
        'ul'      => ['li'],
    ];
    /**
     * Массив пар: 'модель_поведения_тегов' => массив_моделей_поведений_тегов.
     * Накладывает ограничения на вложенность тегов.
     * Тег, принадлежащий указанной слева модели поведения тегов должен закрыться, как только начинается тег, принадлежащий какой-то из моделей поведения, указанных справа.
     *
     * @var array
     */
    protected $ends = [
        'a'       => [
            'a', 'caption', 'div', 'hr', 'li', 'p', 'pre', 'table', 'td', 'tr', 'ul'
        ],
        'caption' => ['tr'],
        'code'    => [],
        'div'     => ['li', 'tr', 'td'],
        'hr'      => [
            'a', 'caption', 'code', 'div', 'hr', 'img', 'li', 'p', 'pre', 'span', 'table', 'td', 'tr', 'ul'
        ],
        'img'     => [
            'a', 'caption', 'code', 'div', 'hr', 'img', 'li', 'p', 'pre', 'span', 'table', 'td', 'tr', 'ul'
        ],
        'li'      => ['li', 'tr', 'td'],
        'p'       => ['div', 'hr', 'li', 'p', 'pre', 'table', 'td', 'tr', 'ul'],
        'pre'     => [],
        'span'    => ['div', 'hr', 'li', 'p', 'pre', 'table', 'td', 'tr', 'ul'],
        'table'   => ['table'],
        'td'      => ['td', 'tr'],
        'tr'      => ['tr'],
        'ul'      => [],
    ];


    /**
     * Метод конечных автоматов
     *
     * Список возможных состояний автомата:
     * 0  - Начало сканирования или находимся вне тега. Ожидаем что угодно.
     * 1  - Встретили символ "[", который считаем началом тега. Ожидаем имя тега, или символ "/".
     * 2  - Нашли в теге неожидавшийся символ "[". Считаем предыдущую строку ошибкой. Ожидаем имя тега, или символ "/".
     * 3  - Нашли в теге синтаксическую ошибку. Текущий символ не является "[". Ожидаем что угодно.
     * 4  - Сразу после "[" нашли символ "/". Предполагаем, что попали в закрывающий тег. Ожидаем имя тега или символ "]".
     * 5  - Сразу после "[" нашли имя тега. Считаем, что находимся в открывающем теге. Ожидаем пробел или "=" или "/" или "]".
     * 6  - Нашли завершение тега "]". Ожидаем что угодно.
     * 7  - Сразу после "[/" нашли имя тега. Ожидаем "]".
     * 8  - В открывающем теге нашли "=". Ожидаем пробел или значение атрибута.
     * 9  - В открывающем теге нашли "/", означающий закрытие тега. Ожидаем "]".
     * 10 - В открывающем теге нашли пробел после имени тега или имени атрибута. Ожидаем "=" или имя другого атрибута или "/" или "]".
     * 11 - Нашли '"' начинающую значение атрибута, ограниченное кавычками. Ожидаем что угодно.
     * 12 - Нашли "'" начинающий значение атрибута, ограниченное апострофами. Ожидаем что угодно.
     * 13 - Нашли начало незакавыченного значения атрибута. Ожидаем что угодно.
     * 14 - В открывающем теге после "=" нашли пробел. Ожидаем значение атрибута.
     * 15 - Нашли имя атрибута. Ожидаем пробел или "=" или "/" или "]".
     * 16 - Находимся внутри значения атрибута, ограниченного кавычками. Ожидаем что угодно.
     * 17 - Завершение значения атрибута. Ожидаем пробел или имя следующего атрибута или "/" или "]".
     * 18 - Находимся внутри значения атрибута, ограниченного апострофами. Ожидаем что угодно.
     * 19 - Находимся внутри незакавыченного значения атрибута. Ожидаем что угодно.
     * 20 - Нашли пробел после значения атрибута. Ожидаем имя следующего атрибута или "/" или "]".
     *
     * Описание конечного автомата:
     */
    protected $finiteAutomaton = [
    // Предыдущие |   Состояния для текущих событий (лексем)   |
    //  состояния |  0 |  1 |  2 |  3 |  4 |  5 |  6 |  7 |  8 |
        0 => [  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ],
        1 => [  2 ,  3 ,  3 ,  3 ,  3 ,  4 ,  3 ,  3 ,  5 ],
        2 => [  2 ,  3 ,  3 ,  3 ,  3 ,  4 ,  3 ,  3 ,  5 ],
        3 => [  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ],
        4 => [  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  7 ],
        5 => [  2 ,  6 ,  3 ,  3 ,  8 ,  9 , 10 ,  3 ,  3 ],
        6 => [  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ],
        7 => [  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ],
        8 => [ 13 , 13 , 11 , 12 , 13 , 13 , 14 , 13 , 13 ],
        9 => [  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ],
        10 => [  2 ,  6 ,  3 ,  3 ,  8 ,  9 ,  3 , 15 , 15 ],
        11 => [ 16 , 16 , 17 , 16 , 16 , 16 , 16 , 16 , 16 ],
        12 => [ 18 , 18 , 18 , 17 , 18 , 18 , 18 , 18 , 18 ],
        13 => [ 19 ,  6 , 19 , 19 , 19 , 19 , 17 , 19 , 19 ],
        14 => [  2 ,  3 , 11 , 12 , 13 , 13 ,  3 , 13 , 13 ],
        15 => [  2 ,  6 ,  3 ,  3 ,  8 ,  9 , 10 ,  3 ,  3 ],
        16 => [ 16 , 16 , 17 , 16 , 16 , 16 , 16 , 16 , 16 ],
        17 => [  2 ,  6 ,  3 ,  3 ,  3 ,  9 , 20 , 15 , 15 ],
        18 => [ 18 , 18 , 18 , 17 , 18 , 18 , 18 , 18 , 18 ],
        19 => [ 19 ,  6 , 19 , 19 , 19 , 19 , 20 , 19 , 19 ],
        20 => [  2 ,  6 ,  3 ,  3 ,  3 ,  9 ,  3 , 15 , 15 ],
    ];

    /**
     * Смайлы
     *
     * @var array
     */
    protected $smiles = [
        ':D' =>
            [
                'title' => 'Very we!',
                'name' => 'resources/images/smiles/1.gif',
            ],
        ':)' =>
            [
                'title' => 'Well',
                'name' => 'resources/images/smiles/2.gif',
            ],
        ':(' =>
            [
                'title' => 'Not so',
                'name' => 'resources/images/smiles/3.gif',
            ],
        ':heap:' =>
            [
                'title' => 'Eyes in a heap',
                'name' => 'resources/images/smiles/4.gif',
            ],
        ':ooi:' =>
            [
                'title' => 'Really?',
                'name' => 'resources/images/smiles/5.gif',
            ],
        ':so:' =>
            [
                'title' => 'So-so',
                'name' => 'resources/images/smiles/6.gif',
            ],
        ':surp:' =>
            [
                'title' => 'It is surprised',
                'name' => 'resources/images/smiles/7.gif',
            ],
        ':ag:' =>
            [
                'title' => 'Again',
                'name' => 'resources/images/smiles/8.gif',
            ],
        ':ir:' =>
            [
                'title' => 'I roll!',
                'name' => 'resources/images/smiles/9.gif',
            ],
        ':oops:' =>
            [
                'title' => 'Oops!',
                'name' => 'resources/images/smiles/44.gif',
            ],
        ':P' =>
            [
                'title' => 'To you',
                'name' => 'resources/images/smiles/11.gif',
            ],
        ':cry:' =>
            [
                'title' => 'Tears',
                'name' => 'resources/images/smiles/12.gif',
            ],
        ':rage:' =>
            [
                'title' => 'I am malicious',
                'name' => 'resources/images/smiles/13.gif',
            ],
        ':B' =>
            [
                'title' => 'All ok',
                'name' => 'resources/images/smiles/14.gif',
            ],
        ':roll:' =>
            [
                'title' => 'Not precisely',
                'name' => 'resources/images/smiles/15.gif',
            ],
        ':wink:' =>
            [
                'title' => 'To wink',
                'name' => 'resources/images/smiles/16.gif',
            ],
        ':yes:' =>
            [
                'title' => 'Yes',
                'name' => 'resources/images/smiles/17.gif',
            ],
        ':bot:' =>
            [
                'title' => 'Has bothered',
                'name' => 'resources/images/smiles/18.gif',
            ],
        ':z)' =>
            [
                'title' => 'Ridiculously',
                'name' => 'resources/images/smiles/19.gif',
            ],
        ':arrow:' =>
            [
                'title' => 'Here',
                'name' => 'resources/images/smiles/20.gif',
            ],
        ':vip:' =>
            [
                'title' => 'Attention',
                'name' => 'resources/images/smiles/21.gif',
            ],
        ':Heppy:' =>
            [
                'title' => 'I congratulate',
                'name' => 'resources/images/smiles/22.gif',
            ],
        ':think:' =>
            [
                'title' => 'I think',
                'name' => 'resources/images/smiles/23.gif',
            ],
        ':bye:' =>
            [
                'title' => 'Farewell',
                'name' => 'resources/images/smiles/24.gif',
            ],
        ':roul:' =>
            [
                'title' => 'Perfectly',
                'name' => 'resources/images/smiles/25.gif',
            ],
        ':pst:' =>
            [
                'title' => 'Fingers',
                'name' => 'resources/images/smiles/26.gif',
            ],
        ':o' =>
            [
                'title' => 'Poorly',
                'name' => 'resources/images/smiles/27.gif',
            ],
        ':closed:' =>
            [
                'title' => 'Veal closed',
                'name' => 'resources/images/smiles/28.gif',
            ],
        ':cens:' =>
            [
                'title' => 'Censorship',
                'name' => 'resources/images/smiles/29.gif',
            ],
        ':tani:' =>
            [
                'title' => 'Features',
                'name' => 'resources/images/smiles/30.gif',
            ],
        ':appl:' =>
            [
                'title' => 'Applause',
                'name' => 'resources/images/smiles/31.gif',
            ],
        ':idnk:' =>
            [
                'title' => 'I do not know',
                'name' => 'resources/images/smiles/32.gif',
            ],
        ':sing:' =>
            [
                'title' => 'Singing',
                'name' => 'resources/images/smiles/33.gif',
            ],
        ':shock:' =>
            [
                'title' => 'Shock',
                'name' => 'resources/images/smiles/34.gif',
            ],
        ':tgu:' =>
            [
                'title' => 'To give up',
                'name' => 'resources/images/smiles/35.gif',
            ],
        ':res:' =>
            [
                'title' => 'Respect',
                'name' => 'resources/images/smiles/36.gif',
            ],
        ':alc:' =>
            [
                'title' => 'Alcohol',
                'name' => 'resources/images/smiles/37.gif',
            ],
        ':lam:' =>
            [
                'title' => 'The lamer',
                'name' => 'resources/images/smiles/38.gif',
            ],
        ':box:' =>
            [
                'title' => 'Boxing',
                'name' => 'resources/images/smiles/39.gif',
            ],
        ':tom:' =>
            [
                'title' => 'Tomato',
                'name' => 'resources/images/smiles/40.gif',
            ],
        ':lol:' =>
            [
                'title' => 'Cheerfully',
                'name' => 'resources/images/smiles/41.gif',
            ],
        ':vill:' =>
            [
                'title' => 'The villain',
                'name' => 'resources/images/smiles/42.gif',
            ],
        ':idea:' =>
            [
                'title' => 'Idea',
                'name' => 'resources/images/smiles/43.gif',
            ],
        ':E' =>
            [
                'title' => 'The big rage',
                'name' => 'resources/images/smiles/45.gif',
            ],
        ':sex:' =>
            [
                'title' => 'Sex',
                'name' => 'resources/images/smiles/46.gif',
            ],
        ':horns:' =>
            [
                'title' => 'Horns',
                'name' => 'resources/images/smiles/47.gif',
            ],
        ':love:' =>
            [
                'title' => 'Love me',
                'name' => 'resources/images/smiles/48.gif',
            ],
        ':poz:' =>
            [
                'title' => 'Happy birthday',
                'name' => 'resources/images/smiles/49.gif',
            ],
        ':roza:' =>
            [
                'title' => 'Roza',
                'name' => 'resources/images/smiles/50.gif',
            ],
        ':meg:' =>
            [
                'title' => 'Megaphone',
                'name' => 'resources/images/smiles/51.gif',
            ],
        ':dj:' =>
            [
                'title' => 'The DJ',
                'name' => 'resources/images/smiles/52.gif',
            ],
        ':rul:' =>
            [
                'title' => 'Rules',
                'name' => 'resources/images/smiles/53.gif',
            ],
        ':offln:' =>
            [
                'title' => 'OffLine',
                'name' => 'resources/images/smiles/54.gif',
            ],
        ':sp:' =>
            [
                'title' => 'Spider',
                'name' => 'resources/images/smiles/55.gif',
            ],
        ':stapp:' =>
            [
                'title' => 'Storm of applause',
                'name' => 'resources/images/smiles/56.gif',
            ],
        ':girl:' =>
            [
                'title' => 'Beautiful girl',
                'name' => 'resources/images/smiles/57.gif',
            ],
        ':heart:' =>
            [
                'title' => 'Heart',
                'name' => 'resources/images/smiles/58.gif',
            ],
        ':kiss:' =>
            [
                'title' => 'Kiss',
                'name' => 'resources/images/smiles/59.gif',
            ],
        ':spam:' =>
            [
                'title' => 'Spam',
                'name' => 'resources/images/smiles/60.gif',
            ],
        ':party:' =>
            [
                'title' => 'Party',
                'name' => 'resources/images/smiles/61.gif',
            ],
        ':ser:' =>
            [
                'title' => 'Song',
                'name' => 'resources/images/smiles/62.gif',
            ],
        ':eam:' =>
            [
                'title' => 'Dream',
                'name' => 'resources/images/smiles/63.gif',
            ],
        ':gift:' =>
            [
                'title' => 'Gift',
                'name' => 'resources/images/smiles/64.gif',
            ],
        ':adore:' =>
            [
                'title' => 'I adore',
                'name' => 'resources/images/smiles/65.gif',
            ],
        ':pie:' =>
            [
                'title' => 'Pie',
                'name' => 'resources/images/smiles/66.gif',
            ],
        ':egg:' =>
            [
                'title' => 'Egg',
                'name' => 'resources/images/smiles/67.gif',
            ],
        ':cnrt:' =>
            [
                'title' => 'Concert',
                'name' => 'resources/images/smiles/68.gif',
            ],
        ':oftop:' =>
            [
                'title' => 'Off Topic',
                'name' => 'resources/images/smiles/69.gif',
            ],
        ':foo:' =>
            [
                'title' => 'Football',
                'name' => 'resources/images/smiles/70.gif',
            ],
        ':mob:' =>
            [
                'title' => 'Cellular',
                'name' => 'resources/images/smiles/71.gif',
            ],
        ':hoo:' =>
            [
                'title' => 'Not hooligan',
                'name' => 'resources/images/smiles/72.gif',
            ],
        ':tog:' =>
            [
                'title' => 'Together',
                'name' => 'resources/images/smiles/73.gif',
            ],
        ':pnk:' =>
            [
                'title' => 'Pancake',
                'name' => 'resources/images/smiles/74.gif',
            ],
        ':pati:' =>
            [
                'title' => 'Party Time',
                'name' => 'resources/images/smiles/75.gif',
            ],
        ':-({|=:' =>
            [
                'title' => 'I here',
                'name' => 'resources/images/smiles/76.gif',
            ],
        ':haaw:' =>
            [
                'title' => 'Head about a wall',
                'name' => 'resources/images/smiles/77.gif',
            ],
        ':angel:' =>
            [
                'title' => 'Angel',
                'name' => 'resources/images/smiles/78.gif',
            ],
        ':kil:' =>
            [
                'title' => 'killer',
                'name' => 'resources/images/smiles/79.gif',
            ],
        ':died:' =>
            [
                'title' => 'Cemetery',
                'name' => 'resources/images/smiles/80.gif',
            ],
        ':cof:' =>
            [
                'title' => 'Coffee',
                'name' => 'resources/images/smiles/81.gif',
            ],
        ':fruit:' =>
            [
                'title' => 'Forbidden fruit',
                'name' => 'resources/images/smiles/82.gif',
            ],
        ':tease:' =>
            [
                'title' => 'To tease',
                'name' => 'resources/images/smiles/83.gif',
            ],
        ':evil:' =>
            [
                'title' => 'Devil',
                'name' => 'resources/images/smiles/84.gif',
            ],
        ':exc:' =>
            [
                'title' => 'Excellently',
                'name' => 'resources/images/smiles/85.gif',
            ],
        ':niah:' =>
            [
                'title' => 'Not I, and he',
                'name' => 'resources/images/smiles/86.gif',
            ],
        ':Head:' =>
            [
                'title' => 'Studio',
                'name' => 'resources/images/smiles/87.gif',
            ],
        ':gl:' =>
            [
                'title' => 'girl',
                'name' => 'resources/images/smiles/88.gif',
            ],
        ':granat:' =>
            [
                'title' => 'Pomegranate',
                'name' => 'resources/images/smiles/89.gif',
            ],
        ':gans:' =>
            [
                'title' => 'Gangster',
                'name' => 'resources/images/smiles/90.gif',
            ],
        ':user:' =>
            [
                'title' => 'User',
                'name' => 'resources/images/smiles/91.gif',
            ],
        ':ny:' =>
            [
                'title' => 'New year',
                'name' => 'resources/images/smiles/92.gif',
            ],
        ':mvol:' =>
            [
                'title' => 'Megavolt',
                'name' => 'resources/images/smiles/93.gif',
            ],
        ':boat:' =>
            [
                'title' => 'In a boat',
                'name' => 'resources/images/smiles/94.gif',
            ],
        ':phone:' =>
            [
                'title' => 'Phone',
                'name' => 'resources/images/smiles/95.gif',
            ],
        ':cop:' =>
            [
                'title' => 'Cop',
                'name' => 'resources/images/smiles/96.gif',
            ],
        ':smok:' =>
            [
                'title' => 'Smoking',
                'name' => 'resources/images/smiles/97.gif',
            ],
        ':bic:' =>
            [
                'title' => 'Bicycle',
                'name' => 'resources/images/smiles/98.gif',
            ],
        ':ban:' =>
            [
                'title' => 'Ban?',
                'name' => 'resources/images/smiles/99.gif',
            ],
        ':bar:' =>
            [
                'title' => 'Bar',
                'name' => 'resources/images/smiles/100.gif',
            ],
    ];


    /**
     * Конструктор класса
     *
     * @param string $webPath Web path
     * @param array $allowed Allowed tags
     */
    public function __construct($webPath = '', array $allowed = null)
    {
        $this->webPath = $webPath;
        $this->reloadSmiles();

        // Removing all traces of parsing of disallowed tags.
        // In case if $allowed is not an array, assuming that everything is allowed
        if ($allowed) {
            foreach ($this->getTags() as $key => $value) {
                if (!\in_array($key, $allowed)) {
                    unset($this->tags[$key]);
                }
            }
        }
    }


    /**
     * Функция парсит текст BBCode и возвращает очередную пару
     *
     *                     "число (тип лексемы) - лексема"
     *
     * Лексема - подстрока строки $this->text, начинающаяся с позиции
     * $this->cursor
     * Типы лексем могут быть следующие:
     *
     * 0 - открывающая квадратная скобка ("[")
     * 1 - закрывающая квадратная cкобка ("]")
     * 2 - двойная кавычка ('"')
     * 3 - апостроф ("'")
     * 4 - равенство ("=")
     * 5 - прямой слэш ("/")
     * 6 - последовательность пробельных символов (" ", "\t", "\n", "\r", "\0" или "\x0B")
     * 7 - последовательность прочих символов, не являющаяся именем тега
     * 8 - имя тега
     *
     * @return array|bool
     */
    protected function getToken()
    {
        $token = '';
        $tokenType = false;
        $charType = false;
        while (true) {
            $tokenType = $charType;
            if (!isset($this->text{$this->cursor})) {
                if (false === $charType) {
                    return false;
                }
                break;
            }
            $char = $this->text{$this->cursor};
            switch ($char) {
                case '[':
                    $charType = 0;
                    break;
                case ']':
                    $charType = 1;
                    break;
                case '"':
                    $charType = 2;
                    break;
                case "'":
                    $charType = 3;
                    break;
                case '=':
                    $charType = 4;
                    break;
                case '/':
                    $charType = 5;
                    break;
                case ' ':
                    $charType = 6;
                    break;
                case "\t":
                    $charType = 6;
                    break;
                case "\n":
                    $charType = 6;
                    break;
                case "\r":
                    $charType = 6;
                    break;
                case "\0":
                    $charType = 6;
                    break;
                case "\x0B":
                    $charType = 6;
                    break;
                default:
                    $charType = 7;
                    break;
            }
            if (false === $tokenType) {
                $token = $char;
            } elseif (5 >= $tokenType) {
                break;
            } elseif ($charType === $tokenType) {
                $token .= $char;
            } else {
                break;
            }
            $this->cursor += 1;
        }

        if (isset($this->tags[\strtolower($token)])) {
            $tokenType = 8;
        }

        return [$tokenType, $token];
    }


    /**
     * Парсер
     *
     * @param array|string $code
     */
    public function parse($code)
    {
        $time_start = \microtime(true);

        if (\is_array($code)) {
            $is_tree = false;
            foreach ($code as $val) {
                if (isset($val['val'])) {
                    $this->setTree($code);
                    $this->syntax = $this->getSyntax();
                    $is_tree = true;
                    break;
                }
            }
            if (!$is_tree) {
                $this->syntax = $code;
                $this->parseTree();
            }
            $this->text = '';
            foreach ($this->syntax as $val) {
                $this->text .= $val['str'];
            }
            $this->statistics['time_parse'] = \microtime(true) - $time_start;

            return;
        }
        $this->text = $code;
        

        $finiteAutomaton = $this->finiteAutomaton();

        if ($finiteAutomaton['decomposition']) {
            $key = $finiteAutomaton['key'];

            if ('text' === $finiteAutomaton['type']) {
                $this->syntax[$key]['str'] .= $finiteAutomaton['decomposition']['str'];
            } else {
                $this->syntax[++$key] = [
                    'type' => 'text',
                    'str' => $finiteAutomaton['decomposition']['str']
                ];
            }
        }

        $this->parseTree();
        $this->statistics['time_parse'] = \microtime(true) - $time_start;
    }


    /**
     * @return array
     */
    protected function finiteAutomaton()
    {
        $finite_automaton = $this->finiteAutomaton;
        $mode = 0;
        $this->syntax = [];
        $decomposition = [];
        $token_key = -1;
        $value = '';
        $name = '';
        $type = false;
        $this->cursor = 0;
        $spacesave = '';

        // Сканируем массив лексем с помощью построенного автомата:
        while ($token = $this->getToken()) {
            $previous_mode = $mode;
            $mode = $finite_automaton[$previous_mode][$token[0]];
            if (-1 < $token_key) {
                $type = $this->syntax[$token_key]['type'];
            } else {
                $type = false;
            }
            switch ($mode) {
                case 0:
                    if ('text' === $type) {
                        $this->syntax[$token_key]['str'] .= $token[1];
                    } else {
                        $this->syntax[++$token_key] = [
                            'type' => 'text',
                            'str' => $token[1]
                        ];
                    }
                    break;
                case 1:
                    $decomposition = [
                        'name'   => '',
                        'type'   => '',
                        'str'    => '[',
                        'layout' => [[0, '[']]
                    ];
                    break;
                case 2:
                    if ('text' === $type) {
                        $this->syntax[$token_key]['str'] .= $decomposition['str'];
                    } else {
                        $this->syntax[++$token_key] = [
                            'type' => 'text',
                            'str' => $decomposition['str']
                        ];
                    }
                    $decomposition = [
                        'name'   => '',
                        'type'   => '',
                        'str'    => '[',
                        'layout' => [[0, '[']]
                    ];
                    break;
                case 3:
                    if ('text' === $type) {
                        $this->syntax[$token_key]['str'] .= $decomposition['str'];
                        $this->syntax[$token_key]['str'] .= $token[1];
                    } else {
                        $this->syntax[++$token_key] = [
                            'type' => 'text',
                            'str' => $decomposition['str'].$token[1]
                        ];
                    }
                    $decomposition = [];
                    break;
                case 4:
                    $decomposition['type'] = 'close';
                    $decomposition['str'] .= '/';
                    $decomposition['layout'][] = [1, '/'];
                    break;
                case 5:
                    $decomposition['type'] = 'open';
                    $name = \strtolower($token[1]);
                    $decomposition['name'] = $name;
                    $decomposition['str'] .= $token[1];
                    $decomposition['layout'][] = [2, $token[1]];
                    $decomposition['attributes'][$name] = '';
                    break;
                case 6:
                    if (!isset($decomposition['name'])) {
                        $decomposition['name'] = '';
                    }
                    if (13 === $previous_mode || 19 === $previous_mode) {
                        $decomposition['layout'][] = [7, $value];
                    }
                    $decomposition['str'] .= ']';
                    $decomposition['layout'][] = [0, ']'];
                    $this->syntax[++$token_key] = $decomposition;
                    $decomposition = [];
                    break;
                case 7:
                    $decomposition['name'] = \strtolower($token[1]);
                    $decomposition['str'] .= $token[1];
                    $decomposition['layout'][] = [2, $token[1]];
                    /* При выходе из тега возвращаем умолчальное значение пробельных незакавыченных тегов */
                    $finite_automaton = $this->finiteAutomaton;
                    break;
                case 8:
                    $decomposition['str'] .= '=';
                    $decomposition['layout'][] = [3, '='];
                    $spacesave = '';
                    break;
                case 9:
                    $decomposition['type'] = 'open/close';
                    $decomposition['str'] .= '/';
                    $decomposition['layout'][] = [1, '/'];
                    break;
                case 10:
                    $decomposition['str'] .= $token[1];
                    $decomposition['layout'][] = [4, $token[1]];
                    break;
                case 11:
                    $decomposition['str'] .= '"';
                    $decomposition['layout'][] = [5, '"'];
                    $value = '';
                    break;
                case 12:
                    $decomposition['str'] .= "'";
                    $decomposition['layout'][] = [5, "'"];
                    $value = '';
                    break;
                case 13:
                    /* Включаем режим пробельных незакавыченных тегов если нужно */
                    $tag = $this->getTagObject($decomposition['name']);
                    if ($tag::ONE_ATTRIBUTE) { // Переписываем некоторые обработки
                        $finite_automaton[8][6] = 13;
                        $finite_automaton[20][7] = 19;
                        $finite_automaton[20][8] = 19;
                        $finite_automaton[13][6] = 19;
                        $finite_automaton[19][6] = 19;
                    }
                    $decomposition['attributes'][$name] = $spacesave . $token[1];
                    $value = $spacesave . $token[1];
                    $decomposition['str'] .= $token[1];
                    $spacesave = '';
                    break;
                case 14:
                    $decomposition['str'] .= $token[1];
                    $decomposition['layout'][] = [4, $token[1]];
                    $spacesave .= $token[1];
                    break;
                case 15:
                    $name = \strtolower($token[1]);
                    $decomposition['str'] .= $token[1];
                    $decomposition['layout'][] = [6, $token[1]];
                    $decomposition['attributes'][$name] = '';
                    break;
                case 16:
                    $decomposition['str'] .= $token[1];
                    $decomposition['attributes'][$name] .= $token[1];
                    $value .= $token[1];
                    break;
                case 17:
                    $decomposition['str'] .= $token[1];
                    $decomposition['layout'][] = [7, $value];
                    $value = '';
                    $decomposition['layout'][] = [5, $token[1]];
                    break;
                case 18:
                    $decomposition['str'] .= $token[1];
                    $decomposition['attributes'][$name] .= $token[1];
                    $value .= $token[1];
                    break;
                case 19:
                    $decomposition['str'] .= $token[1];
                    $decomposition['attributes'][$name] .= $token[1];
                    $value .= $token[1];
                    break;
                case 20:
                    $decomposition['str'] .= $token[1];
                    if (13 === $previous_mode || 19 === $previous_mode) {
                        $decomposition['layout'][] = [7, $value];
                    }
                    $value = '';
                    $decomposition['layout'][] = [4, $token[1]];
                    break;
            }
        }

        return [
            'decomposition' => $decomposition,
            'type' => $type,
            'key' => $token_key,
        ];
    }


    /**
     * specialchars
     *
     * @param string $str
     * @return string
     */
    protected function specialchars($str)
    {
        $chars = [
            '[' => '@l;',
            ']' => '@r;',
            '"' => '@q;',
            "'" => '@a;',
            '@' => '@at;'
        ];
        return \strtr($str, $chars);
    }


    /**
     * unspecialchars
     *
     * @param string $str
     * @return string
     */
    protected function unspecialchars($str)
    {
        $chars = [
            '@l;'  => '[',
            '@r;'  => ']',
            '@q;'  => '"',
            '@a;'  => "'",
            '@at;' => '@'
        ];
        return \strtr($str, $chars);
    }


    /**
     * @param bool $autoLinks
     *
     * @return Xbbcode
     */
    public function setAutoLinks($autoLinks = false)
    {
        $this->autoLinks = (bool)$autoLinks;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAutoLinks()
    {
        return $this->autoLinks;
    }


    /**
     * @param bool $keywordLinks
     *
     * @return Xbbcode
     */
    public function setKeywordLinks($keywordLinks = false)
    {
        $this->keywordLinks = (bool)$keywordLinks;

        return $this;
    }

    /**
     * @return bool
     */
    public function getKeywordLinks()
    {
        return $this->keywordLinks;
    }

    /**
     * @param string $key
     * @param string $name
     * @param string $title
     * @return Xbbcode
     */
    public function setSmile($key, $name, $title = '')
    {
        $this->setMnemonic($key, '<img src="' . \htmlspecialchars($this->webPath . '/' . $name) . '" alt="' . \htmlspecialchars($title) . '" />');

        return $this;
    }

    /**
     * @param string $key
     * @return Xbbcode
     */
    public function removeMnemonic($key)
    {
        unset($this->mnemonics[$key]);

        return $this;
    }


    /**
     * @return array
     */
    public function getMnemonics()
    {
        return $this->mnemonics;
    }


    /**
     * @param array $mnemonics
     * @return Xbbcode
     */
    public function setMnemonics(array $mnemonics)
    {
        $this->mnemonics = $mnemonics;

        return $this;
    }


    /**
     * @param string $key
     * @param string $value
     * @return Xbbcode
     */
    public function setMnemonic($key, $value)
    {
        $this->mnemonics[$key] = $value;

        return $this;
    }


    /**
     * @param bool $enableSmiles
     *
     * @return Xbbcode
     */
    public function setEnableSmiles($enableSmiles = true)
    {
        $this->enableSmiles = (bool)$enableSmiles;

        $this->reloadSmiles();

        return $this;
    }


    /**
     * @return Xbbcode
     */
    protected function reloadSmiles()
    {
        if ($this->getEnableSmiles()) {
            foreach ($this->getSmiles() as $key => $val) {
                $this->setSmile($key, $val['name'], $val['title']);
            }
        } else {
            foreach ($this->getSmiles() as $key => $val) {
                $this->removeMnemonic($key);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function getEnableSmiles()
    {
        return $this->enableSmiles;
    }


    /**
     * @param array $smiles
     *
     * @return Xbbcode
     */
    public function setSmiles(array $smiles)
    {
        $this->smiles = $smiles;

        $this->reloadSmiles();

        return $this;
    }

    /**
     * @return array
     */
    public function getSmiles()
    {
        return $this->smiles;
    }

    /**
     * @param array $tags
     *
     * @return Xbbcode
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }


    /**
     * @param string $tagName
     * @param string $handler Имя класса отнаследованного от абстрактного Tag
     *
     * @return Xbbcode
     */
    public function setTagHandler($tagName, $handler)
    {
        $this->tags[$tagName] = $handler;

        return $this;
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function getTagHandler($tagName)
    {
        return $this->tags[$tagName];
    }


    /**
     * @param string $tagName
     *
     * @return Xbbcode
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;

        return $this;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }


    /**
     * @param array $tree
     *
     * @return Xbbcode
     */
    public function setTree(array $tree)
    {
        $this->tree = $tree;

        return $this;
    }

    /**
     * @return array
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param string $tagName
     *
     * @return Tag
     */
    protected function getTagObject($tagName)
    {
        $this->includeTag($tagName);

        return $this->tagObjects[$this->tags[$tagName]];
    }


    /**
     * Функция проверяет, должен ли тег с именем $current закрыться,
     * если начинается тег с именем $next.
     *
     * @param string $current
     * @param string $next
     * @return bool
     */
    protected function mustCloseTag($current, $next)
    {
        if (isset($this->tags[$current])) {
            $tag = $this->getTagObject($current);
            $currentBehaviour = $tag::BEHAVIOUR;
        } else {
            $currentBehaviour = Tag::BEHAVIOUR;
        }
        if (isset($this->tags[$next])) {
            $tag = $this->getTagObject($next);
            $nextBehaviour = $tag::BEHAVIOUR;
        } else {
            $nextBehaviour = Tag::BEHAVIOUR;
        }

        $mustClose = false;
        if (isset($this->ends[$currentBehaviour])) {
            $mustClose = \in_array($nextBehaviour, $this->ends[$currentBehaviour]);
        }

        return $mustClose;
    }


    /**
     * Возвращает true, если тег с именем $parent может иметь непосредственным
     * потомком тег с именем $child. В противном случае - false.
     * Если $parent - пустая строка, то проверяется, разрешено ли $child входить в
     * корень дерева BBCode.
     *
     * @param string $parent
     * @param string $child
     * @return bool
     */
    protected function isPermissiblyChild($parent, $child)
    {
        $parent = (string) $parent;
        $child = (string) $child;
        if (isset($this->tags[$parent])) {
            $tag = $this->getTagObject($parent);
            $parent_behaviour = $tag::BEHAVIOUR;
        } else {
            $parent_behaviour = Tag::BEHAVIOUR;
        }
        if (isset($this->tags[$child])) {
            $tag = $this->getTagObject($child);
            $child_behaviour = $tag::BEHAVIOUR;
        } else {
            $child_behaviour = Tag::BEHAVIOUR;
        }
        $permissibly = true;
        if (isset($this->children[$parent_behaviour])) {
            $permissibly = \in_array($child_behaviour, $this->children[$parent_behaviour]);
        }

        return $permissibly;
    }


    /**
     * normalizeBracket
     *
     * @param array $syntax
     * @return array
     */
    protected function normalizeBracket(array $syntax)
    {
        $structure = [];
        $structure_key = -1;
        $level = 0;
        $open_tags = [];
        foreach ($syntax as $val) {
            unset($val['layout']);
            switch ($val['type']) {
                case 'text':
                    $val['str'] = $this->unspecialchars($val['str']);

                    $type = (-1 < $structure_key) ? $structure[$structure_key]['type'] : false;
                    if ('text' === $type) {
                        $structure[$structure_key]['str'] .= $val['str'];
                    } else {
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = $level;
                    }
                    break;
                case 'open/close':
                    $val['attributes'] = \array_map([$this, 'unspecialchars'], $val['attributes']);

                    foreach (\array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($this->mustCloseTag($ultimate, $val['name'])) {
                            $structure[++$structure_key] = [
                                'type'  => 'close',
                                'name'  => $ultimate,
                                'str'   => '',
                                'level' => --$level
                            ];
                            unset($open_tags[$ult_key]);
                        } else {
                            break;
                        }
                    }
                    $structure[++$structure_key] = $val;
                    $structure[$structure_key]['level'] = $level;
                    break;
                case 'open':
                    $tag = $this->getTagObject($val['name']);
                    $val['attributes'] = \array_map([$this, 'unspecialchars'], $val['attributes']);
                    foreach (\array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($this->mustCloseTag($ultimate, $val['name'])) {
                            $structure[++$structure_key] = [
                                'type'  => 'close',
                                'name'  => $ultimate,
                                'str'   => '',
                                'level' => --$level
                            ];
                            unset($open_tags[$ult_key]);
                        } else {
                            break;
                        }
                    }
                    if ($tag::IS_CLOSE) {
                        $val['type'] = 'open/close';
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = $level;
                    } else {
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = $level++;
                        $open_tags[] = $val['name'];
                    }
                    break;
                case 'close':
                    if (!$open_tags) {
                        $type = (-1 < $structure_key) ? $structure[$structure_key]['type'] : false;
                        if ('text' === $type) {
                            $structure[$structure_key]['str'] .= $val['str'];
                        } else {
                            $structure[++$structure_key] = [
                                'type'  => 'text',
                                'str'   => $val['str'],
                                'level' => 0
                            ];
                        }
                        break;
                    }
                    if (!$val['name']) {
                        $ultimate = \end($open_tags);
                        $ult_key = \key($open_tags);
                        $val['name'] = $ultimate;
                        $structure[++$structure_key] = $val;
                        $structure[$structure_key]['level'] = --$level;
                        unset($open_tags[$ult_key]);
                        break;
                    }
                    if (!\in_array($val['name'], $open_tags)) {
                        $type = (-1 < $structure_key) ? $structure[$structure_key]['type'] : false;
                        if ('text' === $type) {
                            $structure[$structure_key]['str'] .= $val['str'];
                        } else {
                            $structure[++$structure_key] = [
                                'type'  => 'text',
                                'str'   => $val['str'],
                                'level' => $level
                            ];
                        }
                        break;
                    }
                    foreach (\array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($ultimate !== $val['name']) {
                            $structure[++$structure_key] = [
                                'type'  => 'close',
                                'name'  => $ultimate,
                                'str'   => '',
                                'level' => --$level
                            ];
                            unset($open_tags[$ult_key]);
                        } else {
                            break;
                        }
                    }
                    $structure[++$structure_key] = $val;
                    $structure[$structure_key]['level'] = --$level;
                    unset($open_tags[$ult_key]);
                    break;
            }
        }

        foreach (\array_reverse($open_tags, true) as $ult_key => $ultimate) {
            $structure[++$structure_key] = [
                'type'  => 'close',
                'name'  => $ultimate,
                'str'   => '',
                'level' => --$level
            ];
            unset($open_tags[$ult_key]);
        }

        return $structure;
    }


    /**
     * parseTree
     */
    protected function parseTree()
    {
        /* Превращаем $this->syntax в правильную скобочную структуру */
        $structure = $this->normalizeBracket($this->syntax);
        /* Отслеживаем, имеют ли элементы неразрешенные подэлементы.
           Соответственно этому исправляем $structure. */
        $normalized = [];
        $normal_key = -1;
        $level = 0;
        $open_tags = [];
        $not_tags = [];
        $this->statistics['count_tags'] = 0;

        foreach ($structure as $val) {
            switch ($val['type']) {
                case 'text':
                    $type = (-1 < $normal_key) ? $normalized[$normal_key]['type'] : false;
                    if ('text' === $type) {
                        $normalized[$normal_key]['str'] .= $val['str'];
                    } else {
                        $normalized[++$normal_key] = $val;
                        $normalized[$normal_key]['level'] = $level;
                    }
                    break;
                case 'open/close':
                    $this->includeTag($val['name']);
                    \end($open_tags);
                    $parent = $open_tags ? \current($open_tags) : $this->getTagName();
                    $permissibly = $this->isPermissiblyChild($parent, $val['name']);
                    if (!$permissibly) {
                        $type = (-1 < $normal_key) ? $normalized[$normal_key]['type'] : false;
                        if ('text' === $type) {
                            $normalized[$normal_key]['str'] .= $val['str'];
                        } else {
                            $normalized[++$normal_key] = [
                                'type'  => 'text',
                                'str'   => $val['str'],
                                'level' => $level
                            ];
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = $level;
                    $this->statistics['count_tags'] += 1;
                    break;
                case 'open':
                    $this->includeTag($val['name']);
                    \end($open_tags);
                    $parent = $open_tags ? \current($open_tags) : $this->getTagName();
                    $permissibly = $this->isPermissiblyChild($parent, $val['name']);
                    if (!$permissibly) {
                        $not_tags[$val['level']] = $val['name'];
                        $type = (-1 < $normal_key) ? $normalized[$normal_key]['type'] : false;
                        if ('text' === $type) {
                            $normalized[$normal_key]['str'] .= $val['str'];
                        } else {
                            $normalized[++$normal_key] = [
                                'type'  => 'text',
                                'str'   => $val['str'],
                                'level' => $level
                            ];
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = $level++;
                    $ult_key = \count($open_tags);
                    $open_tags[$ult_key] = $val['name'];
                    $this->statistics['count_tags'] += 1;
                    break;
                case 'close':
                    $not_normal = isset($not_tags[$val['level']]) && $not_tags[$val['level']] = $val['name'];
                    if ($not_normal) {
                        unset($not_tags[$val['level']]);
                        $type = (-1 < $normal_key) ? $normalized[$normal_key]['type'] : false;
                        if ('text' === $type) {
                            $normalized[$normal_key]['str'] .= $val['str'];
                        } else {
                            $normalized[++$normal_key] = [
                                'type'  => 'text',
                                'str'   => $val['str'],
                                'level' => $level
                            ];
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = --$level;
                    $ult_key = \count($open_tags) - 1;
                    unset($open_tags[$ult_key]);
                    $this->statistics['count_tags'] += 1;
                    break;
            }
        }

        unset($structure);

        // Формируем дерево элементов
        $result = [];
        $result_key = -1;
        $open_tags = [];
        $this->statistics['count_level'] = 0;
        foreach ($normalized as $val) {
            switch ($val['type']) {
                case 'text':
                    if (!$val['level']) {
                        $result[++$result_key] = [
                            'type' => 'text',
                            'str' => $val['str']
                        ];
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = [
                        'type' => 'text',
                        'str' => $val['str']
                    ];
                    break;
                case 'open/close':
                    if (!$val['level']) {
                        $result[++$result_key] = [
                            'type'   => 'item',
                            'name'   => $val['name'],
                            'attributes' => $val['attributes'],
                            'val'    => []
                        ];
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = [
                        'type'   => 'item',
                        'name'   => $val['name'],
                        'attributes' => $val['attributes'],
                        'val'    => []
                    ];
                    break;
                case 'open':
                    $open_tags[$val['level']] = [
                        'type'   => 'item',
                        'name'   => $val['name'],
                        'attributes' => $val['attributes'],
                        'val'    => []
                    ];
                    break;
                case 'close':
                    if (!$val['level']) {
                        $result[++$result_key] = $open_tags[0];
                        unset($open_tags[0]);
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = $open_tags[$val['level']];
                    unset($open_tags[$val['level']]);
                    break;
            }
            if ($val['level'] > $this->statistics['count_level']) {
                $this->statistics['count_level'] += 1;
            }
        }

        $this->setTree($result);
    }


    /**
     * getSyntax
     *
     * @param bool|array $tree
     * @return array
     */
    protected function getSyntax($tree = false)
    {
        if (!\is_array($tree)) {
            $tree = $this->getTree();
        }
        $syntax = [];
        foreach ($tree as $elem) {
            if ('text' === $elem['type']) {
                $syntax[] = [
                    'type' => 'text',
                    'str' => $this->specialchars($elem['str'])
                ];
            } else {
                $sub_elems = $this->getSyntax($elem['val']);
                $str = '';
                $layout = [[0, '[']];
                foreach ($elem['attributes'] as $name => $val) {
                    $val = $this->specialchars($val);
                    if ($str) {
                        $str .= ' ';
                        $layout[] = [4, ' '];
                        $layout[] = [6, $name];
                    } else {
                        $layout[] = [2, $name];
                    }
                    $str .= $name;
                    if ($val) {
                        $str .= '="' . $val . '"';
                        $layout[] = [3, '='];
                        $layout[] = [5, '"'];
                        $layout[] = [7, $val];
                        $layout[] = [5, '"'];
                    }
                }
                if ($sub_elems) {
                    $str = '[' . $str . ']';
                } else {
                    $str = '[' . $str . ' /]';
                    $layout[] = [4, ' '];
                    $layout[] = [1, '/'];
                }
                $layout[] = [0, ']'];
                $syntax[] = [
                    'type' => $sub_elems ? 'open' : 'open/close',
                    'str' => $str,
                    'name' => $elem['name'],
                    'attributes' => $elem['attributes'],
                    'layout' => $layout
                ];
                foreach ($sub_elems as $sub_elem) {
                    $syntax[] = $sub_elem;
                }
                if ($sub_elems) {
                    $syntax[] = [
                        'type' => 'close',
                        'str' => '[/' . $elem['name'] . ']',
                        'name' => $elem['name'],
                        'layout' => [
                            [0, '['],
                            [1, '/'],
                            [2, $elem['name']],
                            [0, ']']
                        ]
                    ];
                }
            }
        }

        return $syntax;
    }


    /**
     * insertSmiles
     *
     * @param string $text
     * @return string
     */
    protected function insertMnemonics($text)
    {
        $text = \htmlspecialchars($text, ENT_NOQUOTES);
        if ($this->getAutoLinks()) {
            $search = $this->pregAutoLinks['pattern'];
            $replace = $this->pregAutoLinks['replacement'];
            $text = \preg_replace($search, $replace, $text);
        }
        $text = \str_replace('  ', '&#160;&#160;', \nl2br($text));
        $text = \strtr($text, $this->getMnemonics());

        return $text;
    }


    /**
     * highlight
     *
     * @return string
     */
    public function highlight()
    {
        $time_start = \microtime(true);
        $chars = [
            '@l;'  => '<span class="bb_spec_char">@l;</span>',
            '@r;'  => '<span class="bb_spec_char">@r;</span>',
            '@q;'  => '<span class="bb_spec_char">@q;</span>',
            '@a;'  => '<span class="bb_spec_char">@a;</span>',
            '@at;' => '<span class="bb_spec_char">@at;</span>'
        ];
        $search = $this->pregAutoLinks['pattern'];
        $replace = $this->pregAutoLinks['highlight'];
        $str = '';

        foreach ($this->syntax as $elem) {
            if ('text' === $elem['type']) {
                $elem['str'] = \strtr(\htmlspecialchars($elem['str']), $chars);
                foreach ($this->getMnemonics() as $mnemonic => $value) {
                    $elem['str'] = \str_replace(
                        $mnemonic,
                        '<span class="bb_mnemonic">' . $mnemonic . '</span>',
                        $elem['str']
                    );
                }
                $elem['str'] = \preg_replace($search, $replace, $elem['str']);
                $str .= $elem['str'];
            } else {
                $str .= '<span class="bb_tag">';
                foreach ($elem['layout'] as $val) {
                    switch ($val[0]) {
                        case 0:
                            $str .= '<span class="bb_bracket">' . $val[1] . '</span>';
                            break;
                        case 1:
                            $str .= '<span class="bb_slash">/</span>';
                            break;
                        case 2:
                            $str .= '<span class="bb_tagname">'.$val[1] .'</span>';
                            break;
                        case 3:
                            $str .= '<span class="bb_equal">=</span>';
                            break;
                        case 4:
                            $str .= $val[1];
                            break;
                        case 5:
                            if (!\trim($val[1])) {
                                $str .= $val[1];
                            } else {
                                $str .= '<span class="bb_quote">' . $val[1] . '</span>';
                            }
                            break;
                        case 6:
                            $str .= '<span class="bb_attribute_name">' . \htmlspecialchars($val[1]) . '</span>';
                            break;
                        case 7:
                            if (!\trim($val[1])) {
                                $str .= $val[1];
                            } else {
                                $str .= '<span class="bb_attribute_val">' . \strtr(\htmlspecialchars($val[1]), $chars) . '</span>';
                            }
                            break;
                        default:
                            $str .= $val[1];
                            break;
                    }
                }
                $str .= '</span>';
            }
        }
        $str = \nl2br($str);
        $str = \str_replace('  ', '&#160;&#160;', $str);
        $this->statistics['time_html'] = \microtime(true) - $time_start;

        return $str;
    }


    /**
     * Возвращает HTML код
     *
     * @param array $elems
     * @return string
     */
    public function getHtml(array $elems = null)
    {
        $time_start = \microtime(true);
        if (null === $elems) {
            $elems = $this->getTree();
        }
        $result = '';
        $lbr = 0;
        $rbr = 0;
        foreach ($elems as $elem) {
            if ('text' === $elem['type']) {
                $elem['str'] = $this->insertMnemonics($elem['str']);
                for ($i = 0; $i < $rbr; ++$i) {
                    $elem['str'] = \ltrim($elem['str']);
                    if ('<br />' === \substr($elem['str'], 0, 6)) {
                        $elem['str'] = \substr_replace($elem['str'], '', 0, 6);
                    }
                }
                $result .= $elem['str'];
            } else {
                $tag = $this->getTagObject($elem['name']);

                /* Убираем лишние переводы строк */
                $lbr = $tag::BR_LEFT;
                $rbr = $tag::BR_RIGHT;
                for ($i = 0; $i < $lbr; ++$i) {
                    $result = \rtrim($result);
                    if ('<br />' === \substr($result, -6)) {
                        $result = \substr_replace($result, '', -6, 6);
                    }
                }

                /* Обрабатываем содержимое элемента */
                $tag->setKeywordLinks($this->getKeywordLinks());
                $tag->setAutoLinks($this->getAutoLinks());
                $tag->setTags($this->getTags());
                $tag->setMnemonics($this->getMnemonics());
                $tag->setTagName($elem['name']);
                $tag->setTree($elem['val']);
                $tag->setAttributes($elem['attributes']);

                $result .= $tag; // вызывается __toString
            }
        }

        $result = \preg_replace(
            "'\s*<br \/>\s*<br \/>\s*'si",
            "\n<br />&#160;<br />\n",
            $result
        );
        $this->statistics['time_html'] = \microtime(true) - $time_start;

        return $result;
    }


    /**
     * Функция проверяет, доступен ли класс - обработчик тега с именем $tagName и,
     * если нет, пытается подключить файл с соответствующим классом. Если это не
     * возможно, переназначает тегу обработчик, - сопоставляет ему класс bbcode.
     * Затем инициализирует объект обработчика (если он еще не инициализирован).
     *
     * @param string $tagName
     * @return bool
     */
    protected function includeTag($tagName)
    {
        if (!isset($this->tags[$tagName])) {
            $this->tags[$tagName] = 'bbcode';
        }

        $handler = $this->tags[$tagName];
        if (!isset($this->tagObjects[$handler])) {
            $this->tagObjects[$handler] = new $handler;
        }

        return true;
    }


    /**
     * Статистика работы парсера
     *
     * 'time_parse'        => 0, // Время парсинга
     * 'time_html'         => 0, // Время генерации HTML-а
     * 'count_tags'        => 0, // Число тегов BBCode
     * 'count_level'       => 0  // Число уровней вложенности тегов BBCode
     * 'memory_peak_usage' => 0, // Максимально выделенный объем памяти
     *
     * @return array
     */
    public function getStatistics()
    {
        $this->statistics['memory_peak_usage'] = \memory_get_peak_usage(true);

        return $this->statistics;
    }
}
