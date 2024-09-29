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

use Xbbcode\Tag\A;
use Xbbcode\Tag\Abbr;
use Xbbcode\Tag\Acronym;
use Xbbcode\Tag\Address;
use Xbbcode\Tag\Align;
use Xbbcode\Tag\Altfont;
use Xbbcode\Tag\Bbcode;
use Xbbcode\Tag\Bdo;
use Xbbcode\Tag\Br;
use Xbbcode\Tag\Caption;
use Xbbcode\Tag\Code;
use Xbbcode\Tag\Color;
use Xbbcode\Tag\Email;
use Xbbcode\Tag\Font;
use Xbbcode\Tag\Google;
use Xbbcode\Tag\Hr;
use Xbbcode\Tag\Img;
use Xbbcode\Tag\Li;
use Xbbcode\Tag\Nobb;
use Xbbcode\Tag\Ol;
use Xbbcode\Tag\P;
use Xbbcode\Tag\Quote;
use Xbbcode\Tag\Rutube;
use Xbbcode\Tag\Simple;
use Xbbcode\Tag\Size;
use Xbbcode\Tag\Spoiler;
use Xbbcode\Tag\Table;
use Xbbcode\Tag\TagAbstract;
use Xbbcode\Tag\Td;
use Xbbcode\Tag\Th;
use Xbbcode\Tag\Tr;
use Xbbcode\Tag\Ul;
use Xbbcode\Tag\VkVideo;
use Xbbcode\Tag\Yandex;
use Xbbcode\Tag\Youtube;

class Xbbcode
{
    /**
     * Имя тега, которому сопоставлен экземпляр класса.
     * Пустая строка, если экземпляр не сопоставлен никакому тегу.
     */
    protected string $tagName = '';
    /**
     * Текст BBCode.
     */
    protected string $text = '';
    /**
     * Массив, - результат синтаксического разбора текста BBCode. Описание смотрите в документации.
     */
    protected array $syntax = [];
    /**
     * Дерево семантического разбора текста BBCode. Описание смотрите в документации.
     */
    protected array $tree = [];
    /**
     * Список поддерживаемых тегов с указанием специализированных классов.
     *
     * @var array<string, class-string<TagAbstract>>
     */
    protected array $tags = [
        // Основные теги
        '*' => Li::class,
        'a' => A::class,
        'abbr' => Abbr::class,
        'acronym' => Acronym::class,
        'address' => Address::class,
        'align' => Align::class,
        'anchor' => A::class,
        'b' => Simple::class,
        'bbcode' => Bbcode::class,
        'bdo' => Bdo::class,
        'big' => Simple::class,
        'blockquote' => Quote::class,
        'br' => Br::class,
        'caption' => Caption::class,
        'center' => Align::class,
        'cite' => Simple::class,
        'color' => Color::class,
        'del' => Simple::class,
        'em' => Simple::class,
        'email' => Email::class,
        'font' => Font::class,
        'altfont' => Altfont::class,
        'google' => Google::class,
        'yandex' => Yandex::class,
        'youtube' => Youtube::class,
        'spoiler' => Spoiler::class,
        'hide' => Spoiler::class,
        'h1' => P::class,
        'h2' => P::class,
        'h3' => P::class,
        'h4' => P::class,
        'h5' => P::class,
        'h6' => P::class,
        'hr' => Hr::class,
        'i' => Simple::class,
        'img' => Img::class,
        'ins' => Simple::class,
        'justify' => Align::class,
        'left' => Align::class,
        'li' => Li::class,
        'list' => Ul::class,
        'nobb' => Nobb::class,
        'ol' => Ol::class,
        'p' => P::class,
        'quote' => Quote::class,
        'right' => Align::class,
        'rutube' => Rutube::class,
        's' => Simple::class,
        'size' => Size::class,
        'small' => Simple::class,
        'strike' => Simple::class,
        'strong' => Simple::class,
        'sub' => Simple::class,
        'sup' => Simple::class,
        'table' => Table::class,
        'td' => Td::class,
        'th' => Th::class,
        'tr' => Tr::class,
        'tt' => Simple::class,
        'u' => Simple::class,
        'ul' => Ul::class,
        'url' => A::class,
        'var' => Simple::class,
        'vk' => VkVideo::class,

        // Теги для вывода кода и подсветки синтаксисов (с помощью GeSHi)
        '4cs' => Code::class,
        '6502acme' => Code::class,
        '6502kickass' => Code::class,
        '6502tasm' => Code::class,
        '68000devpac' => Code::class,
        'abap' => Code::class,
        'actionscript' => Code::class,
        'actionscript3' => Code::class,
        'ada' => Code::class,
        'algol' => Code::class,
        'apache' => Code::class,
        'applescript' => Code::class,
        'apt_sources' => Code::class,
        'arm' => Code::class,
        'asm' => Code::class,
        'asp' => Code::class,
        'asymptote' => Code::class,
        'autoconf' => Code::class,
        'autohotkey' => Code::class,
        'autoit' => Code::class,
        'avisynth' => Code::class,
        'awk' => Code::class,
        'bascomavr' => Code::class,
        'bash' => Code::class,
        'basic4gl' => Code::class,
        'bf' => Code::class,
        'bibtex' => Code::class,
        'blitzbasic' => Code::class,
        'bnf' => Code::class,
        'boo' => Code::class,
        'c' => Code::class,
        'c++' => Code::class,
        'c#' => Code::class,
        'c_loadrunner' => Code::class,
        'c_mac' => Code::class,
        'caddcl' => Code::class,
        'cadlisp' => Code::class,
        'cfdg' => Code::class,
        'cfm' => Code::class,
        'chaiscript' => Code::class,
        'cil' => Code::class,
        'clojure' => Code::class,
        'cmake' => Code::class,
        'cobol' => Code::class,
        'code' => Code::class,
        'coffeescript' => Code::class,
        'cpp-qt' => Code::class,
        'css' => Code::class,
        'cuesheet' => Code::class,
        'd' => Code::class,
        'dart' => Code::class,
        'dcl' => Code::class,
        'dcpu16' => Code::class,
        'dcs' => Code::class,
        'delphi' => Code::class,
        'diff' => Code::class,
        'div' => Code::class,
        'dos' => Code::class,
        'e' => Code::class,
        'ecmascript' => Code::class,
        'eiffel' => Code::class,
        'epc' => Code::class,
        'erlang' => Code::class,
        'euphoria' => Code::class,
        'f++' => Code::class,
        'f#' => Code::class,
        'f1' => Code::class,
        'falcon' => Code::class,
        'fo' => Code::class,
        'fortran' => Code::class,
        'freebasic' => Code::class,
        'freeswitch' => Code::class,
        'gambas' => Code::class,
        'gdb' => Code::class,
        'genero' => Code::class,
        'genie' => Code::class,
        'gettext' => Code::class,
        'glsl' => Code::class,
        'gml' => Code::class,
        'gnuplot' => Code::class,
        'go' => Code::class,
        'groovy' => Code::class,
        'gwbasic' => Code::class,
        'haskell' => Code::class,
        'haxe' => Code::class,
        'hicest' => Code::class,
        'hq9plus' => Code::class,
        'html4' => Code::class,
        'html5' => Code::class,
        'icon' => Code::class,
        'idl' => Code::class,
        'ini' => Code::class,
        'inno' => Code::class,
        'intercal' => Code::class,
        'io' => Code::class,
        'j' => Code::class,
        'java' => Code::class,
        'java5' => Code::class,
        'jquery' => Code::class,
        'js' => Code::class,
        'julia' => Code::class,
        'kixtart' => Code::class,
        'klonec' => Code::class,
        'klonecpp' => Code::class,
        'kotlin' => Code::class,
        'latex' => Code::class,
        'lb' => Code::class,
        'ldif' => Code::class,
        'lisp' => Code::class,
        'llvm' => Code::class,
        'locobasic' => Code::class,
        'logtalk' => Code::class,
        'lolcode' => Code::class,
        'lotusformulas' => Code::class,
        'lotusscript' => Code::class,
        'lscript' => Code::class,
        'lsl2' => Code::class,
        'lua' => Code::class,
        'm68k' => Code::class,
        'magiksf' => Code::class,
        'make' => Code::class,
        'mapbasic' => Code::class,
        'matlab' => Code::class,
        'mirc' => Code::class,
        'mmix' => Code::class,
        'modula2' => Code::class,
        'modula3' => Code::class,
        'mpasm' => Code::class,
        'mxml' => Code::class,
        'mysql' => Code::class,
        'nagios' => Code::class,
        'netrexx' => Code::class,
        'newlisp' => Code::class,
        'nginx' => Code::class,
        'nsis' => Code::class,
        'oberon2' => Code::class,
        'objc' => Code::class,
        'objeck' => Code::class,
        'ocaml' => Code::class,
        'octave' => Code::class,
        'oobas' => Code::class,
        'oorexx' => Code::class,
        'oracle' => Code::class,
        'oracle11' => Code::class,
        'oxygene' => Code::class,
        'oz' => Code::class,
        'parasail' => Code::class,
        'parigp' => Code::class,
        'pascal' => Code::class,
        'pcre' => Code::class,
        'per' => Code::class,
        'perl' => Code::class,
        'perl6' => Code::class,
        'pf' => Code::class,
        'php' => Code::class,
        'pic16' => Code::class,
        'pike' => Code::class,
        'pixelbender' => Code::class,
        'pli' => Code::class,
        'plsql' => Code::class,
        'postgresql' => Code::class,
        'povray' => Code::class,
        'powershell' => Code::class,
        'pre' => Code::class,
        'proftpd' => Code::class,
        'progress' => Code::class,
        'prolog' => Code::class,
        'properties' => Code::class,
        'providex' => Code::class,
        'purebasic' => Code::class,
        'pycon' => Code::class,
        'pys60' => Code::class,
        'python' => Code::class,
        'q' => Code::class,
        'qbasic' => Code::class,
        'rails' => Code::class,
        'rebol' => Code::class,
        'reg' => Code::class,
        'rexx' => Code::class,
        'robots' => Code::class,
        'rpmspec' => Code::class,
        'rsplus' => Code::class,
        'ruby' => Code::class,
        'rust' => Code::class,
        'sas' => Code::class,
        'sass' => Code::class,
        'scala' => Code::class,
        'scheme' => Code::class,
        'scilab' => Code::class,
        'sdlbasic' => Code::class,
        'smalltalk' => Code::class,
        'smarty' => Code::class,
        'spark' => Code::class,
        'sparql' => Code::class,
        'sql' => Code::class,
        'stonescript' => Code::class,
        'swift' => Code::class,
        'systemverilog' => Code::class,
        't-sql' => Code::class,
        'tcl' => Code::class,
        'teraterm' => Code::class,
        'text' => Code::class,
        'thinbasic' => Code::class,
        'twig' => Code::class,
        'typoscript' => Code::class,
        'unicon' => Code::class,
        'upc' => Code::class,
        'urbi' => Code::class,
        'uscript' => Code::class,
        'vala' => Code::class,
        'vb' => Code::class,
        'vb.net' => Code::class,
        'vedit' => Code::class,
        'verilog' => Code::class,
        'vhdl' => Code::class,
        'vim' => Code::class,
        'visualfoxpro' => Code::class,
        'visualprolog' => Code::class,
        'whitespace' => Code::class,
        'whois' => Code::class,
        'winbatch' => Code::class,
        'xbasic' => Code::class,
        'xml' => Code::class,
        'xorg_conf' => Code::class,
        'xpp' => Code::class,
        'yaml' => Code::class,
        'z80' => Code::class,
        'zxbasic' => Code::class,
    ];
    /**
     * Смайлики и прочие мнемоники. Массив: 'мнемоника' => 'ее_замена'.
     *
     * @var array<string, string>
     */
    protected array $mnemonics = [];
    /**
     * Флажок, включающий/выключающий автоматические ссылки.
     */
    protected bool $autoLinks = false;
    /**
     * Массив замен для автоматических ссылок.
     *
     * @var array{pattern: string[], replacement: string[], highlight: string[]}
     */
    protected array $pregAutoLinks = [
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
     */
    protected bool $keywordLinks = false;

    /**
     * Флажок, включающий/выключающий подстановку смайлов.
     */
    protected bool $enableSmiles = true;

    /**
     * Статистические сведения по обработке BBCode.
     *
     * @var array{time_parse: float, time_html: float, count_tags: int, count_level: int, memory_peak_usage: int}
     */
    protected array $statistics = [
        'time_parse' => 0.0, // Время парсинга
        'time_html' => 0.0, // Время генерации HTML-а
        'count_tags' => 0, // Число тегов BBCode
        'count_level' => 0, // Число уровней вложенности тегов BBCode
        'memory_peak_usage' => 0, // Максимально выделенный объем памяти
    ];
    /**
     * Публичная WEB директория.
     * Ссылается на директорию resources для формирования смайликов и CSS стилей.
     */
    protected string $webPath = '';
    /**
     * Для нужд парсера. - Позиция очередного обрабатываемого символа.
     */
    private int $cursor = 0;
    /**
     * Массив объектов, - представителей отдельных тегов.
     *
     * @var TagAbstract[]
     */
    private array $tagObjects = [];
    /**
     * Массив пар: 'модель_поведения_тегов' => массив_моделей_поведений_тегов.
     * Накладывает ограничения на вложенность тегов.
     * Теги с моделями поведения, не указанными в массиве справа, вложенные в тег с моделью поведения, указанной слева, будут игнорироваться как неправильно вложенные.
     *
     * @var array<string, string[]>
     */
    protected array $children = [
        'a' => ['code', 'img', 'span'],
        'caption' => ['a', 'code', 'img', 'span'],
        'code' => [],
        'div' => ['a', 'code', 'div', 'hr', 'img', 'p', 'pre', 'span', 'table', 'ul'],
        'hr' => [],
        'img' => [],
        'li' => ['a', 'code', 'div', 'hr', 'img', 'p', 'pre', 'span', 'table', 'ul'],
        'p' => ['a', 'code', 'img', 'span'],
        'pre' => [],
        'span' => ['a', 'code', 'img', 'span'],
        'table' => ['caption', 'tr'],
        'td' => ['a', 'code', 'div', 'hr', 'img', 'p', 'pre', 'span', 'table', 'ul'],
        'tr' => ['td'],
        'ul' => ['li'],
    ];
    /**
     * Массив пар: 'модель_поведения_тегов' => массив_моделей_поведений_тегов.
     * Накладывает ограничения на вложенность тегов.
     * Тег, принадлежащий указанной слева модели поведения тегов должен закрыться, как только начинается тег, принадлежащий какой-то из моделей поведения, указанных справа.
     *
     * @var array<string, string[]>
     */
    protected array $ends = [
        'a' => [
            'a', 'caption', 'div', 'hr', 'li', 'p', 'pre', 'table', 'td', 'tr', 'ul',
        ],
        'caption' => ['tr'],
        'code' => [],
        'div' => ['li', 'tr', 'td'],
        'hr' => [
            'a', 'caption', 'code', 'div', 'hr', 'img', 'li', 'p', 'pre', 'span', 'table', 'td', 'tr', 'ul',
        ],
        'img' => [
            'a', 'caption', 'code', 'div', 'hr', 'img', 'li', 'p', 'pre', 'span', 'table', 'td', 'tr', 'ul',
        ],
        'li' => ['li', 'tr', 'td'],
        'p' => ['div', 'hr', 'li', 'p', 'pre', 'table', 'td', 'tr', 'ul'],
        'pre' => [],
        'span' => ['div', 'hr', 'li', 'p', 'pre', 'table', 'td', 'tr', 'ul'],
        'table' => ['table'],
        'td' => ['td', 'tr'],
        'tr' => ['tr'],
        'ul' => [],
    ];

    /**
     * Метод конечных автоматов.
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
     *
     * @var array<int, int[]>
     */
    protected array $finiteAutomaton = [
        // Предыдущие |   Состояния для текущих событий (лексем)   |
        //  состояния |  0 |  1 |  2 |  3 |  4 |  5 |  6 |  7 |  8 |
        0 => [1,  0,  0,  0,  0,  0,  0,  0,  0],
        1 => [2,  3,  3,  3,  3,  4,  3,  3,  5],
        2 => [2,  3,  3,  3,  3,  4,  3,  3,  5],
        3 => [1,  0,  0,  0,  0,  0,  0,  0,  0],
        4 => [2,  6,  3,  3,  3,  3,  3,  3,  7],
        5 => [2,  6,  3,  3,  8,  9, 10,  3,  3],
        6 => [1,  0,  0,  0,  0,  0,  0,  0,  0],
        7 => [2,  6,  3,  3,  3,  3,  3,  3,  3],
        8 => [13, 13, 11, 12, 13, 13, 14, 13, 13],
        9 => [2,  6,  3,  3,  3,  3,  3,  3,  3],
        10 => [2,  6,  3,  3,  8,  9,  3, 15, 15],
        11 => [16, 16, 17, 16, 16, 16, 16, 16, 16],
        12 => [18, 18, 18, 17, 18, 18, 18, 18, 18],
        13 => [19,  6, 19, 19, 19, 19, 17, 19, 19],
        14 => [2,  3, 11, 12, 13, 13,  3, 13, 13],
        15 => [2,  6,  3,  3,  8,  9, 10,  3,  3],
        16 => [16, 16, 17, 16, 16, 16, 16, 16, 16],
        17 => [2,  6,  3,  3,  3,  9, 20, 15, 15],
        18 => [18, 18, 18, 17, 18, 18, 18, 18, 18],
        19 => [19,  6, 19, 19, 19, 19, 20, 19, 19],
        20 => [2,  6,  3,  3,  3,  9,  3, 15, 15],
    ];

    /**
     * Смайлы.
     *
     * @var array<string, array<string, string>>
     */
    protected array $smiles = [
        ':D' => [
            'title' => 'Very we!',
            'name' => 'resources/images/smiles/1.gif',
        ],
        ':)' => [
            'title' => 'Well',
            'name' => 'resources/images/smiles/2.gif',
        ],
        ':(' => [
            'title' => 'Not so',
            'name' => 'resources/images/smiles/3.gif',
        ],
        ':heap:' => [
            'title' => 'Eyes in a heap',
            'name' => 'resources/images/smiles/4.gif',
        ],
        ':ooi:' => [
            'title' => 'Really?',
            'name' => 'resources/images/smiles/5.gif',
        ],
        ':so:' => [
            'title' => 'So-so',
            'name' => 'resources/images/smiles/6.gif',
        ],
        ':surp:' => [
            'title' => 'It is surprised',
            'name' => 'resources/images/smiles/7.gif',
        ],
        ':ag:' => [
            'title' => 'Again',
            'name' => 'resources/images/smiles/8.gif',
        ],
        ':ir:' => [
            'title' => 'I roll!',
            'name' => 'resources/images/smiles/9.gif',
        ],
        ':oops:' => [
            'title' => 'Oops!',
            'name' => 'resources/images/smiles/44.gif',
        ],
        ':P' => [
            'title' => 'To you',
            'name' => 'resources/images/smiles/11.gif',
        ],
        ':cry:' => [
            'title' => 'Tears',
            'name' => 'resources/images/smiles/12.gif',
        ],
        ':rage:' => [
            'title' => 'I am malicious',
            'name' => 'resources/images/smiles/13.gif',
        ],
        ':B' => [
            'title' => 'All ok',
            'name' => 'resources/images/smiles/14.gif',
        ],
        ':roll:' => [
            'title' => 'Not precisely',
            'name' => 'resources/images/smiles/15.gif',
        ],
        ':wink:' => [
            'title' => 'To wink',
            'name' => 'resources/images/smiles/16.gif',
        ],
        ':yes:' => [
            'title' => 'Yes',
            'name' => 'resources/images/smiles/17.gif',
        ],
        ':bot:' => [
            'title' => 'Has bothered',
            'name' => 'resources/images/smiles/18.gif',
        ],
        ':z)' => [
            'title' => 'Ridiculously',
            'name' => 'resources/images/smiles/19.gif',
        ],
        ':arrow:' => [
            'title' => 'Here',
            'name' => 'resources/images/smiles/20.gif',
        ],
        ':vip:' => [
            'title' => 'Attention',
            'name' => 'resources/images/smiles/21.gif',
        ],
        ':Heppy:' => [
            'title' => 'I congratulate',
            'name' => 'resources/images/smiles/22.gif',
        ],
        ':think:' => [
            'title' => 'I think',
            'name' => 'resources/images/smiles/23.gif',
        ],
        ':bye:' => [
            'title' => 'Farewell',
            'name' => 'resources/images/smiles/24.gif',
        ],
        ':roul:' => [
            'title' => 'Perfectly',
            'name' => 'resources/images/smiles/25.gif',
        ],
        ':pst:' => [
            'title' => 'Fingers',
            'name' => 'resources/images/smiles/26.gif',
        ],
        ':o' => [
            'title' => 'Poorly',
            'name' => 'resources/images/smiles/27.gif',
        ],
        ':closed:' => [
            'title' => 'Veal closed',
            'name' => 'resources/images/smiles/28.gif',
        ],
        ':cens:' => [
            'title' => 'Censorship',
            'name' => 'resources/images/smiles/29.gif',
        ],
        ':tani:' => [
            'title' => 'Features',
            'name' => 'resources/images/smiles/30.gif',
        ],
        ':appl:' => [
            'title' => 'Applause',
            'name' => 'resources/images/smiles/31.gif',
        ],
        ':idnk:' => [
            'title' => 'I do not know',
            'name' => 'resources/images/smiles/32.gif',
        ],
        ':sing:' => [
            'title' => 'Singing',
            'name' => 'resources/images/smiles/33.gif',
        ],
        ':shock:' => [
            'title' => 'Shock',
            'name' => 'resources/images/smiles/34.gif',
        ],
        ':tgu:' => [
            'title' => 'To give up',
            'name' => 'resources/images/smiles/35.gif',
        ],
        ':res:' => [
            'title' => 'Respect',
            'name' => 'resources/images/smiles/36.gif',
        ],
        ':alc:' => [
            'title' => 'Alcohol',
            'name' => 'resources/images/smiles/37.gif',
        ],
        ':lam:' => [
            'title' => 'The lamer',
            'name' => 'resources/images/smiles/38.gif',
        ],
        ':box:' => [
            'title' => 'Boxing',
            'name' => 'resources/images/smiles/39.gif',
        ],
        ':tom:' => [
            'title' => 'Tomato',
            'name' => 'resources/images/smiles/40.gif',
        ],
        ':lol:' => [
            'title' => 'Cheerfully',
            'name' => 'resources/images/smiles/41.gif',
        ],
        ':vill:' => [
            'title' => 'The villain',
            'name' => 'resources/images/smiles/42.gif',
        ],
        ':idea:' => [
            'title' => 'Idea',
            'name' => 'resources/images/smiles/43.gif',
        ],
        ':E' => [
            'title' => 'The big rage',
            'name' => 'resources/images/smiles/45.gif',
        ],
        ':sex:' => [
            'title' => 'Sex',
            'name' => 'resources/images/smiles/46.gif',
        ],
        ':horns:' => [
            'title' => 'Horns',
            'name' => 'resources/images/smiles/47.gif',
        ],
        ':love:' => [
            'title' => 'Love me',
            'name' => 'resources/images/smiles/48.gif',
        ],
        ':poz:' => [
            'title' => 'Happy birthday',
            'name' => 'resources/images/smiles/49.gif',
        ],
        ':roza:' => [
            'title' => 'Roza',
            'name' => 'resources/images/smiles/50.gif',
        ],
        ':meg:' => [
            'title' => 'Megaphone',
            'name' => 'resources/images/smiles/51.gif',
        ],
        ':dj:' => [
            'title' => 'The DJ',
            'name' => 'resources/images/smiles/52.gif',
        ],
        ':rul:' => [
            'title' => 'Rules',
            'name' => 'resources/images/smiles/53.gif',
        ],
        ':offln:' => [
            'title' => 'OffLine',
            'name' => 'resources/images/smiles/54.gif',
        ],
        ':sp:' => [
            'title' => 'Spider',
            'name' => 'resources/images/smiles/55.gif',
        ],
        ':stapp:' => [
            'title' => 'Storm of applause',
            'name' => 'resources/images/smiles/56.gif',
        ],
        ':girl:' => [
            'title' => 'Beautiful girl',
            'name' => 'resources/images/smiles/57.gif',
        ],
        ':heart:' => [
            'title' => 'Heart',
            'name' => 'resources/images/smiles/58.gif',
        ],
        ':kiss:' => [
            'title' => 'Kiss',
            'name' => 'resources/images/smiles/59.gif',
        ],
        ':spam:' => [
            'title' => 'Spam',
            'name' => 'resources/images/smiles/60.gif',
        ],
        ':party:' => [
            'title' => 'Party',
            'name' => 'resources/images/smiles/61.gif',
        ],
        ':ser:' => [
            'title' => 'Song',
            'name' => 'resources/images/smiles/62.gif',
        ],
        ':eam:' => [
            'title' => 'Dream',
            'name' => 'resources/images/smiles/63.gif',
        ],
        ':gift:' => [
            'title' => 'Gift',
            'name' => 'resources/images/smiles/64.gif',
        ],
        ':adore:' => [
            'title' => 'I adore',
            'name' => 'resources/images/smiles/65.gif',
        ],
        ':pie:' => [
            'title' => 'Pie',
            'name' => 'resources/images/smiles/66.gif',
        ],
        ':egg:' => [
            'title' => 'Egg',
            'name' => 'resources/images/smiles/67.gif',
        ],
        ':cnrt:' => [
            'title' => 'Concert',
            'name' => 'resources/images/smiles/68.gif',
        ],
        ':oftop:' => [
            'title' => 'Off Topic',
            'name' => 'resources/images/smiles/69.gif',
        ],
        ':foo:' => [
            'title' => 'Football',
            'name' => 'resources/images/smiles/70.gif',
        ],
        ':mob:' => [
            'title' => 'Cellular',
            'name' => 'resources/images/smiles/71.gif',
        ],
        ':hoo:' => [
            'title' => 'Not hooligan',
            'name' => 'resources/images/smiles/72.gif',
        ],
        ':tog:' => [
            'title' => 'Together',
            'name' => 'resources/images/smiles/73.gif',
        ],
        ':pnk:' => [
            'title' => 'Pancake',
            'name' => 'resources/images/smiles/74.gif',
        ],
        ':pati:' => [
            'title' => 'Party Time',
            'name' => 'resources/images/smiles/75.gif',
        ],
        ':-({|=:' => [
            'title' => 'I here',
            'name' => 'resources/images/smiles/76.gif',
        ],
        ':haaw:' => [
            'title' => 'Head about a wall',
            'name' => 'resources/images/smiles/77.gif',
        ],
        ':angel:' => [
            'title' => 'Angel',
            'name' => 'resources/images/smiles/78.gif',
        ],
        ':kil:' => [
            'title' => 'killer',
            'name' => 'resources/images/smiles/79.gif',
        ],
        ':died:' => [
            'title' => 'Cemetery',
            'name' => 'resources/images/smiles/80.gif',
        ],
        ':cof:' => [
            'title' => 'Coffee',
            'name' => 'resources/images/smiles/81.gif',
        ],
        ':fruit:' => [
            'title' => 'Forbidden fruit',
            'name' => 'resources/images/smiles/82.gif',
        ],
        ':tease:' => [
            'title' => 'To tease',
            'name' => 'resources/images/smiles/83.gif',
        ],
        ':evil:' => [
            'title' => 'Devil',
            'name' => 'resources/images/smiles/84.gif',
        ],
        ':exc:' => [
            'title' => 'Excellently',
            'name' => 'resources/images/smiles/85.gif',
        ],
        ':niah:' => [
            'title' => 'Not I, and he',
            'name' => 'resources/images/smiles/86.gif',
        ],
        ':Head:' => [
            'title' => 'Studio',
            'name' => 'resources/images/smiles/87.gif',
        ],
        ':gl:' => [
            'title' => 'girl',
            'name' => 'resources/images/smiles/88.gif',
        ],
        ':granat:' => [
            'title' => 'Pomegranate',
            'name' => 'resources/images/smiles/89.gif',
        ],
        ':gans:' => [
            'title' => 'Gangster',
            'name' => 'resources/images/smiles/90.gif',
        ],
        ':user:' => [
            'title' => 'User',
            'name' => 'resources/images/smiles/91.gif',
        ],
        ':ny:' => [
            'title' => 'New year',
            'name' => 'resources/images/smiles/92.gif',
        ],
        ':mvol:' => [
            'title' => 'Megavolt',
            'name' => 'resources/images/smiles/93.gif',
        ],
        ':boat:' => [
            'title' => 'In a boat',
            'name' => 'resources/images/smiles/94.gif',
        ],
        ':phone:' => [
            'title' => 'Phone',
            'name' => 'resources/images/smiles/95.gif',
        ],
        ':cop:' => [
            'title' => 'Cop',
            'name' => 'resources/images/smiles/96.gif',
        ],
        ':smok:' => [
            'title' => 'Smoking',
            'name' => 'resources/images/smiles/97.gif',
        ],
        ':bic:' => [
            'title' => 'Bicycle',
            'name' => 'resources/images/smiles/98.gif',
        ],
        ':ban:' => [
            'title' => 'Ban?',
            'name' => 'resources/images/smiles/99.gif',
        ],
        ':bar:' => [
            'title' => 'Bar',
            'name' => 'resources/images/smiles/100.gif',
        ],
    ];

    /**
     * Конструктор класса.
     *
     * @param string     $webPath Web path
     * @param array|null $allowed Allowed tags
     */
    public function __construct(string $webPath = '', ?array $allowed = null)
    {
        $this->webPath = $webPath;
        $this->reloadSmiles();

        // Removing all traces of parsing of disallowed tags.
        // In case if $allowed is not an array, assuming that everything is allowed
        if ($allowed) {
            foreach ($this->getTags() as $key => $value) {
                if (!\in_array($key, $allowed, true)) {
                    unset($this->tags[$key]);
                }
            }
        }
    }

    /**
     * Функция парсит текст BBCode и возвращает очередную пару.
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
     */
    protected function getToken(): ?array
    {
        $token = '';
        $tokenType = false;
        $charType = false;
        while (true) {
            $tokenType = $charType;
            if (!isset($this->text[$this->cursor])) {
                if (false === $charType) {
                    return null;
                }
                break;
            }
            $char = $this->text[$this->cursor];
            $charType = match ($char) {
                '[' => 0,
                ']' => 1,
                '"' => 2,
                "'" => 3,
                '=' => 4,
                '/' => 5,
                ' ' => 6,
                "\t" => 6,
                "\n" => 6,
                "\r" => 6,
                "\0" => 6,
                "\x0B" => 6,
                default => 7,
            };
            if (false === $tokenType) {
                $token = $char;
            } elseif (5 >= $tokenType) {
                break;
            } elseif ($charType === $tokenType) {
                $token .= $char;
            } else {
                break;
            }
            ++$this->cursor;
        }

        if (isset($this->tags[\strtolower($token)])) {
            $tokenType = 8;
        }

        return [$tokenType, $token];
    }

    public function parse(array|string $code): void
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
                    'str' => $finiteAutomaton['decomposition']['str'],
                ];
            }
        }

        $this->parseTree();
        $this->statistics['time_parse'] = \microtime(true) - $time_start;
    }

    protected function finiteAutomaton(): array
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
                            'str' => $token[1],
                        ];
                    }
                    break;
                case 1:
                    $decomposition = [
                        'name' => '',
                        'type' => '',
                        'str' => '[',
                        'layout' => [[0, '[']],
                    ];
                    break;
                case 2:
                    if ('text' === $type) {
                        $this->syntax[$token_key]['str'] .= $decomposition['str'];
                    } else {
                        $this->syntax[++$token_key] = [
                            'type' => 'text',
                            'str' => $decomposition['str'],
                        ];
                    }
                    $decomposition = [
                        'name' => '',
                        'type' => '',
                        'str' => '[',
                        'layout' => [[0, '[']],
                    ];
                    break;
                case 3:
                    if ('text' === $type) {
                        $this->syntax[$token_key]['str'] .= $decomposition['str'];
                        $this->syntax[$token_key]['str'] .= $token[1];
                    } else {
                        $this->syntax[++$token_key] = [
                            'type' => 'text',
                            'str' => $decomposition['str'].$token[1],
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
                    $decomposition['attributes'][$name] = $spacesave.$token[1];
                    $value = $spacesave.$token[1];
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

    protected function specialchars(string $str): string
    {
        $chars = [
            '[' => '@l;',
            ']' => '@r;',
            '"' => '@q;',
            "'" => '@a;',
            '@' => '@at;',
        ];

        return \strtr($str, $chars);
    }

    protected function unspecialchars(string $str): string
    {
        $chars = [
            '@l;' => '[',
            '@r;' => ']',
            '@q;' => '"',
            '@a;' => "'",
            '@at;' => '@',
        ];

        return \strtr($str, $chars);
    }

    public function setAutoLinks(bool $autoLinks = false): self
    {
        $this->autoLinks = $autoLinks;

        return $this;
    }

    public function getAutoLinks(): bool
    {
        return $this->autoLinks;
    }

    public function setKeywordLinks(bool $keywordLinks = false): self
    {
        $this->keywordLinks = $keywordLinks;

        return $this;
    }

    public function getKeywordLinks(): bool
    {
        return $this->keywordLinks;
    }

    public function setSmile(string $key, string $name, string $title = ''): self
    {
        $this->setMnemonic($key, '<img src="'.\htmlspecialchars($this->webPath.'/'.$name).'" alt="'.\htmlspecialchars($title).'" />');

        return $this;
    }

    public function removeMnemonic(string $key): self
    {
        unset($this->mnemonics[$key]);

        return $this;
    }

    public function getMnemonics(): array
    {
        return $this->mnemonics;
    }

    public function setMnemonics(array $mnemonics): self
    {
        $this->mnemonics = $mnemonics;

        return $this;
    }

    public function setMnemonic(string $key, string $value): self
    {
        $this->mnemonics[$key] = $value;

        return $this;
    }

    public function setEnableSmiles(bool $enableSmiles = true): self
    {
        $this->enableSmiles = $enableSmiles;

        $this->reloadSmiles();

        return $this;
    }

    protected function reloadSmiles(): self
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

    public function getEnableSmiles(): bool
    {
        return $this->enableSmiles;
    }

    /**
     * @param array<string, array<string, string>> $smiles
     */
    public function setSmiles(array $smiles): self
    {
        $this->smiles = $smiles;

        $this->reloadSmiles();

        return $this;
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function getSmiles(): array
    {
        return $this->smiles;
    }

    /**
     * @param array<string, string> $tags
     */
    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array<string, string>
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTagHandler(string $tagName, string $handler): self
    {
        if (!\is_subclass_of($handler, TagAbstract::class, true)) {
            throw new \RuntimeException(\sprintf('%s should implements the %s class', $handler, TagAbstract::class));
        }
        $this->tags[$tagName] = $handler;

        return $this;
    }

    public function getTagHandler(string $tagName): string
    {
        return $this->tags[$tagName];
    }

    public function setTagName(string $tagName): self
    {
        $this->tagName = $tagName;

        return $this;
    }

    public function getTagName(): string
    {
        return $this->tagName;
    }

    public function setTree(array $tree): self
    {
        $this->tree = $tree;

        return $this;
    }

    public function getTree(): array
    {
        return $this->tree;
    }

    protected function getTagObject(string $tagName): TagAbstract
    {
        $this->includeTag($tagName);

        return $this->tagObjects[$this->tags[$tagName]];
    }

    /**
     * Функция проверяет, должен ли тег с именем $current закрыться,
     * если начинается тег с именем $next.
     */
    protected function mustCloseTag(string $current, string $next): bool
    {
        if (isset($this->tags[$current])) {
            $tag = $this->getTagObject($current);
            $currentBehaviour = $tag::BEHAVIOUR;
        } else {
            $currentBehaviour = TagAbstract::BEHAVIOUR;
        }
        if (isset($this->tags[$next])) {
            $tag = $this->getTagObject($next);
            $nextBehaviour = $tag::BEHAVIOUR;
        } else {
            $nextBehaviour = TagAbstract::BEHAVIOUR;
        }

        $mustClose = false;
        if (isset($this->ends[$currentBehaviour])) {
            $mustClose = \in_array($nextBehaviour, $this->ends[$currentBehaviour], true);
        }

        return $mustClose;
    }

    /**
     * Возвращает true, если тег с именем $parent может иметь непосредственным
     * потомком тег с именем $child. В противном случае - false.
     * Если $parent - пустая строка, то проверяется, разрешено ли $child входить в
     * корень дерева BBCode.
     */
    protected function isPermissiblyChild(string $parent, string $child): bool
    {
        if (isset($this->tags[$parent])) {
            $tag = $this->getTagObject($parent);
            $parent_behaviour = $tag::BEHAVIOUR;
        } else {
            $parent_behaviour = TagAbstract::BEHAVIOUR;
        }
        if (isset($this->tags[$child])) {
            $tag = $this->getTagObject($child);
            $child_behaviour = $tag::BEHAVIOUR;
        } else {
            $child_behaviour = TagAbstract::BEHAVIOUR;
        }
        $permissibly = true;
        if (isset($this->children[$parent_behaviour])) {
            $permissibly = \in_array($child_behaviour, $this->children[$parent_behaviour], true);
        }

        return $permissibly;
    }

    protected function normalizeBracket(array $syntax): array
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
                                'type' => 'close',
                                'name' => $ultimate,
                                'str' => '',
                                'level' => --$level,
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
                                'type' => 'close',
                                'name' => $ultimate,
                                'str' => '',
                                'level' => --$level,
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
                                'type' => 'text',
                                'str' => $val['str'],
                                'level' => 0,
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
                    if (!\in_array($val['name'], $open_tags, true)) {
                        $type = (-1 < $structure_key) ? $structure[$structure_key]['type'] : false;
                        if ('text' === $type) {
                            $structure[$structure_key]['str'] .= $val['str'];
                        } else {
                            $structure[++$structure_key] = [
                                'type' => 'text',
                                'str' => $val['str'],
                                'level' => $level,
                            ];
                        }
                        break;
                    }
                    foreach (\array_reverse($open_tags, true) as $ult_key => $ultimate) {
                        if ($ultimate !== $val['name']) {
                            $structure[++$structure_key] = [
                                'type' => 'close',
                                'name' => $ultimate,
                                'str' => '',
                                'level' => --$level,
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
                'type' => 'close',
                'name' => $ultimate,
                'str' => '',
                'level' => --$level,
            ];
            unset($open_tags[$ult_key]);
        }

        return $structure;
    }

    protected function parseTree(): void
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
                                'type' => 'text',
                                'str' => $val['str'],
                                'level' => $level,
                            ];
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = $level;
                    ++$this->statistics['count_tags'];
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
                                'type' => 'text',
                                'str' => $val['str'],
                                'level' => $level,
                            ];
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = $level++;
                    $ult_key = \count($open_tags);
                    $open_tags[$ult_key] = $val['name'];
                    ++$this->statistics['count_tags'];
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
                                'type' => 'text',
                                'str' => $val['str'],
                                'level' => $level,
                            ];
                        }
                        break;
                    }
                    $normalized[++$normal_key] = $val;
                    $normalized[$normal_key]['level'] = --$level;
                    $ult_key = \count($open_tags) - 1;
                    unset($open_tags[$ult_key]);
                    ++$this->statistics['count_tags'];
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
                            'str' => $val['str'],
                        ];
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = [
                        'type' => 'text',
                        'str' => $val['str'],
                    ];
                    break;
                case 'open/close':
                    if (!$val['level']) {
                        $result[++$result_key] = [
                            'type' => 'item',
                            'name' => $val['name'],
                            'attributes' => $val['attributes'],
                            'val' => [],
                        ];
                        break;
                    }
                    $open_tags[$val['level'] - 1]['val'][] = [
                        'type' => 'item',
                        'name' => $val['name'],
                        'attributes' => $val['attributes'],
                        'val' => [],
                    ];
                    break;
                case 'open':
                    $open_tags[$val['level']] = [
                        'type' => 'item',
                        'name' => $val['name'],
                        'attributes' => $val['attributes'],
                        'val' => [],
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
                ++$this->statistics['count_level'];
            }
        }

        $this->setTree($result);
    }

    protected function getSyntax(bool|array $tree = false): array
    {
        if (!\is_array($tree)) {
            $tree = $this->getTree();
        }
        $syntax = [];
        foreach ($tree as $elem) {
            if ('text' === $elem['type']) {
                $syntax[] = [
                    'type' => 'text',
                    'str' => $this->specialchars($elem['str']),
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
                        $str .= '="'.$val.'"';
                        $layout[] = [3, '='];
                        $layout[] = [5, '"'];
                        $layout[] = [7, $val];
                        $layout[] = [5, '"'];
                    }
                }
                if ($sub_elems) {
                    $str = '['.$str.']';
                } else {
                    $str = '['.$str.' /]';
                    $layout[] = [4, ' '];
                    $layout[] = [1, '/'];
                }
                $layout[] = [0, ']'];
                $syntax[] = [
                    'type' => $sub_elems ? 'open' : 'open/close',
                    'str' => $str,
                    'name' => $elem['name'],
                    'attributes' => $elem['attributes'],
                    'layout' => $layout,
                ];
                foreach ($sub_elems as $sub_elem) {
                    $syntax[] = $sub_elem;
                }
                if ($sub_elems) {
                    $syntax[] = [
                        'type' => 'close',
                        'str' => '[/'.$elem['name'].']',
                        'name' => $elem['name'],
                        'layout' => [
                            [0, '['],
                            [1, '/'],
                            [2, $elem['name']],
                            [0, ']'],
                        ],
                    ];
                }
            }
        }

        return $syntax;
    }

    protected function insertMnemonics(string $text): string
    {
        $text = \htmlspecialchars($text, \ENT_NOQUOTES);
        if ($this->getAutoLinks()) {
            $search = $this->pregAutoLinks['pattern'];
            $replace = $this->pregAutoLinks['replacement'];
            $text = \preg_replace($search, $replace, $text);
        }
        $text = \str_replace('  ', '&#160;&#160;', \nl2br($text));
        $text = \strtr($text, $this->getMnemonics());

        return $text;
    }

    public function highlight(): string
    {
        $time_start = \microtime(true);
        $chars = [
            '@l;' => '<span class="bb_spec_char">@l;</span>',
            '@r;' => '<span class="bb_spec_char">@r;</span>',
            '@q;' => '<span class="bb_spec_char">@q;</span>',
            '@a;' => '<span class="bb_spec_char">@a;</span>',
            '@at;' => '<span class="bb_spec_char">@at;</span>',
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
                        '<span class="bb_mnemonic">'.$mnemonic.'</span>',
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
                            $str .= '<span class="bb_bracket">'.$val[1].'</span>';
                            break;
                        case 1:
                            $str .= '<span class="bb_slash">/</span>';
                            break;
                        case 2:
                            $str .= '<span class="bb_tagname">'.$val[1].'</span>';
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
                                $str .= '<span class="bb_quote">'.$val[1].'</span>';
                            }
                            break;
                        case 6:
                            $str .= '<span class="bb_attribute_name">'.\htmlspecialchars($val[1]).'</span>';
                            break;
                        case 7:
                            if (!\trim($val[1])) {
                                $str .= $val[1];
                            } else {
                                $str .= '<span class="bb_attribute_val">'.\strtr(\htmlspecialchars($val[1]), $chars).'</span>';
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

    public function getHtml(?array $elems = null): string
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
                    if (\str_starts_with($elem['str'], '<br />')) {
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
                    if (\str_ends_with($result, '<br />')) {
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
            "'\s*<br \/>\s*<br \/>\s*'i",
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
     */
    protected function includeTag(string $tagName): void
    {
        if (!isset($this->tags[$tagName])) {
            $this->tags[$tagName] = 'bbcode';
        }

        $handler = $this->tags[$tagName];
        if (!isset($this->tagObjects[$handler])) {
            $this->tagObjects[$handler] = new $handler();
        }
    }

    /**
     * Статистика работы парсера.
     *
     * time_parse - Время парсинга
     * time_html - Время генерации HTML-а
     * count_tags - Число тегов BBCode
     * count_level - Число уровней вложенности тегов BBCode
     * memory_peak_usage - Максимально выделенный объем памяти
     *
     * @return array{time_parse: float, time_html: float, count_tags: int, count_level: int, memory_peak_usage: int}
     */
    public function getStatistics(): array
    {
        $this->statistics['memory_peak_usage'] = \memory_get_peak_usage(true);

        return $this->statistics;
    }
}
