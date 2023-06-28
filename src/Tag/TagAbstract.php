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
use Xbbcode\Xbbcode;

abstract class TagAbstract extends Xbbcode
{
    /**
     * Задаёт возможность наличия у последнего атрибута у тега значений без необходимости наличия кавычек для значений с пробелами.
     * Пример: [altfont=Comic Sans MS]sometext[/altfont] или [altfont size="22" font=Comic Sans MS]sometext[/altfont]
     * По умолчанию выключено.
     */
    public const ONE_ATTRIBUTE = false;
    /**
     * Модель поведения тега (в плане вложенности), которому сопоставлен экземпляр данного класса.
     * Модели поведения могут быть следующими:
     * 'a'       - ссылки, якоря
     * 'caption' - заголовки таблиц
     * 'code'    - линейные контейнеры кода
     * 'div'     - блочные элементы
     * 'hr'      - горизонтальные линии
     * 'img'     - картинки
     * 'li'      - элементы списков
     * 'p'       - блочные элементы типа абзацев и заголовков
     * 'pre'     - блочные контейнеры кода
     * 'span'    - линейные элементы
     * 'table'   - таблицы
     * 'td'      - ячейки таблиц
     * 'tr'      - строки таблиц
     * 'ul'      - списки
     * Конкретное содержание в понятие "модель поведения" вкладывается настройками.
     */
    public const BEHAVIOUR = 'div';
    /**
     * Число разрывов строк, которые должны быть проигнорированы перед тегом
     */
    public const BR_LEFT = 0;
    /**
     * Число разрывов строк, которые должны быть проигнорированы после тега.
     */
    public const BR_RIGHT = 0;

    /**
     * Указывает на одиночные тэги типа [br] или [hr].
     */
    public const IS_CLOSE = false;

    /**
     * Массив значений атрибутов тега, которому сопоставлен экземпляр класса.
     * Пуст, если экземпляр не сопоставлен никакому тегу.
     */
    protected array $attributes = [];

    /**
     * Конструктор
     */
    public function __construct()
    {
        // не вызываем родительский конструктор
    }

    /**
     * @return string HTML code
     */
    abstract public function __toString(): string;

    /**
     * @return Attributes Tag attributes
     */
    abstract protected function getAttributes(): Attributes;

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    protected function cleanTreeText(): void
    {
        foreach ($this->getTree() as $key => $item) {
            if ('text' === $item['type']) {
                unset($this->tree[$key]);
            }
        }
    }

    protected function getTreeText(): string
    {
        $text = '';
        foreach ($this->getTree() as $val) {
            if ('text' === $val['type']) {
                $text .= $val['str'];
            }
        }

        return $text;
    }

    protected function getBody(): string
    {
        if (\in_array(static::BEHAVIOUR, ['table', 'tr', 'ul'])) {
            $this->cleanTreeText();
        }

        return $this->getHtml($this->getTree());
    }

    /**
     * Функция преобразует строку URL в соответствии с RFC 3986.
     */
    protected function parseUrl(string $url): string
    {
        $parse = \parse_url($url);

        $out = '';
        if (isset($parse['scheme'])) {
            $out .= $parse['scheme'].'://';
        } elseif (0 === \strpos($url, '//')) {
            $out .= '//';
        }

        if (isset($parse['user'], $parse['pass'])) {
            $out .= \rawurlencode($parse['user']).':'.\rawurlencode($parse['pass']).'@';
        } elseif (isset($parse['user'])) {
            $out .= \rawurlencode($parse['user']).'@';
        }
        if (isset($parse['host'])) {
            $out .= \rawurlencode($parse['host']);
        }
        if (isset($parse['port'])) {
            $out .= ':'.$parse['port'];
        }
        if (isset($parse['path'])) {
            $out .= \str_replace('%2F', '/', \rawurlencode($parse['path']));
        }
        if (isset($parse['query'])) {
            $query = $this->parseStr($parse['query']);
            // parse_str($parse['query'], $query); //replace spaces and dots

            // PHP 5.4.0 - PHP_QUERY_RFC3986
            $out .= '?'.\str_replace('+', '%20', \rtrim(\http_build_query($query, '', '&'), '='));
        }
        if (isset($parse['fragment'])) {
            $out .= '#'.\rawurlencode($parse['fragment']);
        }

        return $out;
    }

    /**
     * Аналог parse_str но без преобразования точек и пробелов в подчеркивания.
     */
    private function parseStr(string $str): array
    {
        $original = ['.', ' '];
        $replace = ["xbbdot\txbbdot", "xbbspace\txbbspace"];

        $query = [];
        \parse_str(\str_replace($original, $replace, $str), $query);

        foreach ($query as $k => $v) {
            unset($query[$k]);
            $query[\str_replace($replace, $original, $k)] = \str_replace($replace, $original, $v);
        }

        return $query;
    }

    protected function isValidSize(string $size): bool
    {
        return (bool) \preg_match('/^[0-9]+(?:px|%)?$/i', $size);
    }

    protected function isValidNumber(string $number): bool
    {
        return (bool) \preg_match('/^[0-9]+$/', $number);
    }

    protected function isValidFontSize(string $size): bool
    {
        return (bool) \preg_match('/^(?:\+|-)?(?:1|2|3|4|5|6|7){1}$/', $size);
    }

    protected function isValidAlign(string $align): bool
    {
        return \in_array(\strtolower($align), ['left', 'right', 'center', 'justify'], true);
    }

    protected function isValidValign(string $valign): bool
    {
        return \in_array(\strtolower($valign), ['top', 'middle', 'bottom', 'baseline'], true);
    }

    protected function isValidUlType(string $ulType): bool
    {
        return \in_array(\strtolower($ulType), ['disc', 'circle', 'square'], true);
    }

    protected function isValidOlType(string $olType): bool
    {
        return (bool) \preg_match('/^[a-z0-9]+$/i', $olType);
    }

    protected function isValidTarget(string $target): bool
    {
        return \in_array(\strtolower($target), ['_blank', '_self', '_parent', '_top'], true);
    }
}
