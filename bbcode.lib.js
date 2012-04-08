/******************************************************************************
 *                                                                            *
 *   bbcode.lib.js, v 0.00 2007/07/25 - This is part of xBB library           *
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

function bbcode(code) {
    /* Текст BBCode */
    this.text = code;
    /* Результат синтаксического разбора текста BBCode. */
    this.syntax = [];
    /* Список поддерживаемых тегов. */
    this.tags = [];
    /* Флажок, включающий/выключающий автоматические ссылки. */
    this.autolinks = true;
    /* Массив замен для автоматических ссылок. */
    this.preg_autolinks = {
        pattern   : [
            /(\w+:\/\/[A-z0-9\.\?\+\-\/_=&%#:;]+[\w/=]+)/,
            /([^/])(www\.[A-z0-9\.\?\+\-/_=&%#:;]+[\w/=]+)/,
            /([\w]+[\w\-\.]+@[\w\-\.]+\.[\w]+)/
        ],
        highlight : [
            '<' + 'span class="bb_autolink">$1<' + '/span>',
            '$1<' + 'span class="bb_autolink">$2<' + '/span>',
            '<' + 'span class="bb_autolink">$1<' + '/span>'
        ]
    };
    /* Подсвечиваемые смайлики и прочие мнемоники. */
    this.mnemonics = [];
    /* Основные смайлики, предлагаемые на выбор пользователя. */
    this.smiles = [];
    /* Список шрифтов, предлагаемых на выбор пользователя */
    this.fonts = [];
    /* Палитра цветов, предлагаемых на выбор пользователя */
    this.colors = [];
    /* Id ифрейма с подсвеченным bbcode */
    this.iframeId = 'xbb_iframe';
    /* Id textarea с текстом bbcode */
    this.textareaId = 'xbb_textarea';
    /*
    div, используемый как контейнер данных,
    передаваемых из одного фрема в другой
    */
    this.transportDiv = parent.document.getElementById('xbb_transport_div');
    /*
    Режим, в котором в данный момент находится редактор. Возможные значения:
    'plain' (textarea) или 'highlight' (подсветка синтаксиса)
    */
    this.state = 'plain';
    /* Для нужд парсера. - Позиция очередного обрабатываемого символа. */
    var _cursor = 0;
    /*
    get_token() - Функция парсит текст BBCode и возвращает очередную пару

                        "число (тип лексемы) - лексема"

    Лексема - подстрока строки this.text, начинающаяся с позиции _cursor
    Типы лексем могут быть следующие:

    0 - открывющая квадратная скобка ("[")
    1 - закрывающая квадратная cкобка ("]")
    2 - двойная кавычка ('"')
    3 - апостроф ("'")
    4 - равенство ("=")
    5 - прямой слэш ("/")
    6 - последовательность пробельных символов
        (" ", "\t", "\n", "\r", "\0" или "\x0B")
    7 - последовательность прочих символов, не являющаяся именем тега
    8 - имя тега
    */
    this.get_token = function() {
        var token = '';
        var token_type = NaN;
        var char_type = NaN;
        var cur_char;
        while (true) {
            token_type = char_type;
            if (! this.text.charAt(_cursor)) {
                if (isNaN(char_type)) {
                    return false;
                } else {
                    break;
                }
            }
            cur_char = this.text.charAt(_cursor);
            switch (cur_char) {
                case '[':
                    char_type = 0;
                    break;
                case ']':
                    char_type = 1;
                    break;
                case '"':
                    char_type = 2;
                    break;
                case "'":
                    char_type = 3;
                    break;
                case "=":
                    char_type = 4;
                    break;
                case '/':
                    char_type = 5;
                    break;
                case ' ':
                    char_type = 6;
                    break;
                case "\t":
                    char_type = 6;
                    break;
                case "\n":
                    char_type = 6;
                    break;
                case "\r":
                    char_type = 6;
                    break;
                case "\0":
                    char_type = 6;
                    break;
                case "\x0B":
                    char_type = 6;
                    break;
                default:
                    char_type = 7;
            }
            if (isNaN(token_type)) {
                token = cur_char;
            } else if (5 >= token_type) {
                break;
            } else if (char_type == token_type) {
                token += cur_char;
            } else {
                break;
            }
            _cursor += 1;
        }
        if (this.in_array(token.toLowerCase(), this.tags)) {
            token_type = 8;
        }
        return [token_type, token];
    };

    this.parse = function(code) {
        if (code) { this.text = code; }
        /*
        Используем метод конечных автоматов
        Список возможных состояний автомата:
        0  - Начало сканирования или находимся вне тега. Ожидаем что угодно.
        1  - Встретили символ "[", который считаем началом тега. Ожидаем имя
             тега, или символ "/".
        2  - Нашли в теге неожидавшийся символ "[". Считаем предыдущую строку
             ошибкой. Ожидаем имя тега, или символ "/".
        3  - Нашли в теге синтаксическую ошибку. Текущий символ не является "[".
             Ожидаем что угодно.
        4  - Сразу после "[" нашли символ "/". Предполагаем, что попали в
             закрывающий тег. Ожидаем имя тега или символ "]".
        5  - Сразу после "[" нашли имя тега. Считаем, что находимся в
             открывающем теге. Ожидаем пробел или "=" или "/" или "]".
        6  - Нашли завершение тега "]". Ожидаем что угодно.
        7  - Сразу после "[/" нашли имя тега. Ожидаем "]".
        8  - В открывающем теге нашли "=". Ожидаем пробел или значение атрибута.
        9  - В открывающем теге нашли "/", означающий закрытие тега. Ожидаем
             "]".
        10 - В открывающем теге нашли пробел после имени тега или имени
             атрибута. Ожидаем "=" или имя другого атрибута или "/" или "]".
        11 - Нашли '"' начинающую значение атрибута, ограниченное кавычками.
             Ожидаем что угодно.
        12 - Нашли "'" начинающий значение атрибута, ограниченное апострофами.
             Ожидаем что угодно.
        13 - Нашли начало незакавыченного значения атрибута. Ожидаем что угодно.
        14 - В открывающем теге после "=" нашли пробел. Ожидаем значение
             атрибута.
        15 - Нашли имя атрибута. Ожидаем пробел или "=" или "/" или "]".
        16 - Находимся внутри значения атрибута, ограниченного кавычками.
             Ожидаем что угодно.
        17 - Завершение значения атрибута. Ожидаем пробел или имя следующего
             атрибута или "/" или "]".
        18 - Находимся внутри значения атрибута, ограниченного апострофами.
             Ожидаем что угодно.
        19 - Находимся внутри незакавыченного значения атрибута. Ожидаем что
             угодно.
        20 - Нашли пробел после значения атрибута. Ожидаем имя следующего
             атрибута или "/" или "]".

        Описание конечного автомата:
        */
        var finite_automaton = {
         // Предыдущие |   Состояния для текущих событий (лексем)   |
         //  состояния |  0 |  1 |  2 |  3 |  4 |  5 |  6 |  7 |  8 |
                   0 : [  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ]
                ,  1 : [  2 ,  3 ,  3 ,  3 ,  3 ,  4 ,  3 ,  3 ,  5 ]
                ,  2 : [  2 ,  3 ,  3 ,  3 ,  3 ,  4 ,  3 ,  3 ,  5 ]
                ,  3 : [  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ]
                ,  4 : [  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  7 ]
                ,  5 : [  2 ,  6 ,  3 ,  3 ,  8 ,  9 , 10 ,  3 ,  3 ]
                ,  6 : [  1 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ,  0 ]
                ,  7 : [  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ]
                ,  8 : [ 13 , 13 , 11 , 12 , 13 , 13 , 14 , 13 , 13 ]
                ,  9 : [  2 ,  6 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ,  3 ]
                , 10 : [  2 ,  6 ,  3 ,  3 ,  8 ,  9 ,  3 , 15 , 15 ]
                , 11 : [ 16 , 16 , 17 , 16 , 16 , 16 , 16 , 16 , 16 ]
                , 12 : [ 18 , 18 , 18 , 17 , 18 , 18 , 18 , 18 , 18 ]
                , 13 : [ 19 ,  6 , 19 , 19 , 19 , 19 , 17 , 19 , 19 ]
                , 14 : [  2 ,  3 , 11 , 12 , 13 , 13 ,  3 , 13 , 13 ]
                , 15 : [  2 ,  6 ,  3 ,  3 ,  8 ,  9 , 10 ,  3 ,  3 ]
                , 16 : [ 16 , 16 , 17 , 16 , 16 , 16 , 16 , 16 , 16 ]
                , 17 : [  2 ,  6 ,  3 ,  3 ,  3 ,  9 , 20 , 15 , 15 ]
                , 18 : [ 18 , 18 , 18 , 17 , 18 , 18 , 18 , 18 , 18 ]
                , 19 : [ 19 ,  6 , 19 , 19 , 19 , 19 , 20 , 19 , 19 ]
                , 20 : [  2 ,  6 ,  3 ,  3 ,  3 ,  9 ,  3 , 15 , 15 ]
            };
        // Закончили описание конечного автомата
        var mode = 0;
        this.syntax = [];
        var decomposition = {};
        var token_key = -1;
        var value = '';
        var previous_mode;
        var type;
        var name;
        _cursor = 0;
        var token = this.get_token();
        // Сканируем массив лексем с помощью построенного автомата:
        while (token) {
            previous_mode = mode;
            mode = finite_automaton[previous_mode][token[0]];
            if (-1 < token_key) {
                type = this.syntax[token_key].type;
            } else {
                type = false;
            }
            switch (mode) {
                case 0:
                    if ('text' == type) {
                        this.syntax[token_key].str += token[1];
                    } else {
                        this.syntax[++token_key] = {
                            type : 'text',
                            str  : token[1]
                        };
                    }
                    break;
                case 1:
                    decomposition = {
                        name   : '',
                        type   : '',
                        str    : '[',
                        layout : [[0, '[']]
                    };
                    break;
                case 2:
                    if ('text' == type) {
                        this.syntax[token_key].str += decomposition.str;
                    } else {
                        this.syntax[++token_key] = {
                            type : 'text',
                            str  : decomposition.str
                        };
                    }
                    decomposition = {
                        name   : '',
                        type   : '',
                        str    : '[',
                        layout : [[0, '[']]
                    };
                    break;
                case 3:
                    if ('text' == type) {
                        this.syntax[token_key].str += decomposition.str;
                        this.syntax[token_key].str += token[1];
                    } else {
                        this.syntax[++token_key] = {
                            type : 'text',
                            str  : decomposition.str + token[1]
                        };
                    }
                    decomposition = {};
                    break;
                case 4:
                    decomposition.type = 'close';
                    decomposition.str += '/';
                    decomposition.layout[decomposition.layout.length] = [1, '/'];
                    break;
                case 5:
                    decomposition.type = 'open';
                    name = token[1].toLowerCase();
                    decomposition.name = name;
                    decomposition.str += token[1];
                    decomposition.layout[decomposition.layout.length] = [2, token[1]];
                    if (! decomposition.attrib) {
                        decomposition.attrib = {};
                    }
                    decomposition.attrib[name] = '';
                    break;
                case 6:
                    if (! decomposition.name) {
                        decomposition.name = '';
                    }
                    if (13 == previous_mode || 19 == previous_mode) {
                        decomposition.layout[decomposition.layout.length] = [7, value];
                    }
                    decomposition.str += ']';
                    decomposition.layout[decomposition.layout.length] = [0, ']'];
                    this.syntax[++token_key] = decomposition;
                    decomposition = {};
                    break;
                case 7:
                    decomposition.name = token[1].toLowerCase();
                    decomposition.str += token[1];
                    decomposition.layout[decomposition.layout.length] = [2, token[1]];
                    break;
                case 8:
                    decomposition.str += '=';
                    decomposition.layout[decomposition.layout.length] = [3, '='];
                    break;
                case 9:
                    decomposition.type = 'open/close';
                    decomposition.str += '/';
                    decomposition.layout[decomposition.layout.length] = [1, '/'];
                    break;
                case 10:
                    decomposition.str += token[1];
                    decomposition.layout[decomposition.layout.length] = [4, token[1]];
                    break;
                case 11:
                    decomposition.str += '"';
                    decomposition.layout[decomposition.layout.length] = [5, '"'];
                    value = '';
                    break;
                case 12:
                    decomposition.str += "'";
                    decomposition.layout[decomposition.layout.length] = [5, "'"];
                    value = '';
                    break;
                case 13:
                    if (! decomposition.attrib) {
                        decomposition.attrib = {};
                    }
                    decomposition.attrib[name] = token[1];
                    value = token[1];
                    decomposition.str += token[1];
                    break;
                case 14:
                    decomposition.str += token[1];
                    decomposition.layout[decomposition.layout.length] = [4, token[1]];
                    break;
                case 15:
                    name = token[1].toLowerCase();
                    decomposition.str += token[1];
                    decomposition.layout[decomposition.layout.length] = [6, token[1]];
                    if (! decomposition.attrib) {
                        decomposition.attrib = {};
                    }
                    decomposition.attrib[name] = '';
                    break;
                case 16:
                    decomposition.str += token[1];
                    if (! decomposition.attrib) {
                        decomposition.attrib = {};
                    }
                    decomposition.attrib[name] += token[1];
                    value += token[1];
                    break;
                case 17:
                    decomposition.str += token[1];
                    decomposition.layout[decomposition.layout.length] = [7, value];
                    value = '';
                    decomposition.layout[decomposition.layout.length] = [5, token[1]];
                    break;
                case 18:
                    decomposition.str += token[1];
                    decomposition.attrib[name] += token[1];
                    value += token[1];
                    break;
                case 19:
                    decomposition.str += token[1];
                    decomposition.attrib[name] += token[1];
                    value += token[1];
                    break;
                case 20:
                    decomposition.str += token[1];
                    if (13 == previous_mode || 19 == previous_mode) {
                        decomposition.layout[decomposition.layout.length] = [7, value];
                    }
                    value = '';
                    decomposition.layout[decomposition.layout.length] = [4, token[1]];
                    break;
            }
            token = this.get_token();
        }
        if (decomposition.type) {
            if ('text' == type) {
                this.syntax[token_key].str += decomposition.str;
            } else {
                this.syntax[++token_key] = {
                    type : 'text',
                    str  : decomposition.str
                };
            }
        }
    };

    this.highlight = function() {
        var chars = [
            ['@l;' , '<span class="bb_spec_char">@l;</span>' ],
            ['@r;' , '<span class="bb_spec_char">@r;</span>' ],
            ['@q;' , '<span class="bb_spec_char">@q;</span>' ],
            ['@a;' , '<span class="bb_spec_char">@a;</span>' ],
            ['@at;', '<span class="bb_spec_char">@at;</span>']
        ];
        var link_search = this.preg_autolinks.pattern;
        var link_replace = this.preg_autolinks.highlight;
        var str = '';
        var elem;
        var val;
        for (var i_syntax in this.syntax) {
            elem = this.syntax[i_syntax].str;
            if ('text' == this.syntax[i_syntax].type) {
                elem = this.htmlspecialchars(elem);
                elem = this.strtr(elem, chars);
                for (var i_mnemonic in this.mnemonics) {
                    elem = elem.replace(
                        this.mnemonics[i_mnemonic],
                        '<span class="bb_mnemonic">' + this.mnemonics[i_mnemonic] + '</span>'
                    );
                }
                for (var i = 0; link_search[i]; ++i) {
                    elem = elem.replace(link_search[i], link_replace[i]);
                }
                str += elem;
            } else {
                str += '<span class="bb_tag">';
                var trim_val = '';
                for (var i_val in this.syntax[i_syntax].layout) {
                    val = this.syntax[i_syntax].layout[i_val];
                    switch (val[0]) {
                        case 0:
                            str += '<span class="bb_bracket">' + val[1] + '</span>';
                            break;
                        case 1:
                            str += '<span class="bb_slash">/</span>';
                            break;
                        case 2:
                            str += '<span class="bb_tagname">' + val[1] + '</span>';
                            break;
                        case 3:
                            str += '<span class="bb_equal">=</span>';
                            break;
                        case 4:
                            str += val[1];
                            break;
                        case 5:
                            trim_val = val[1].replace(/\s/, '');
                            if (! trim_val) {
                            	str += val[1];
                            } else {
                                str += '<span class="bb_quote">' + val[1] + '</span>';
                            }
                            break;
                        case 6:
                            str += '<span class="bb_attrib_name">'
                                + this.htmlspecialchars(val[1]) + '</span>';
                            break;
                        case 7:
                            trim_val = val[1].replace(/\s/, '');
                            if (! trim_val) {
                            	str += val[1];
                            } else {
                                str += '<span class="bb_attrib_val">'
                                    + this.strtr(this.htmlspecialchars(val[1]), chars)
                                    + '</span>';
                            }
                            break;
                        default:
                            str += val[1];
                    }
                }
                str += '</span>';
            }
        }
        str = this.nl2br(str);
        str = str.replace(/\s\s/, '&nbsp;&nbsp;');
        return str;
    };

    /*
    Текстовое содержимое узла с заменой <br /> на разрыв строки и окрыжением
    <p> разрывами строк.
    */
    this.innerText = function(node) {
        if (node.innerText) {
            return node.innerText;
        }
        if (node.textContent) {
            for (var c, t = [], l = (c = node.childNodes).length, p, i = 0; i < l; i++) {
                t[t.length] =
                    'p' == (p = c[i].nodeName.toLowerCase())
                        ? '\n' + c[i].textContent + '\n'
                        : 'br' == p ? '\n' : c[i].textContent;
            }
            return t.join('');
        }
        return '';
    };

    /* Аналог функции in_array в PHP */
    this.in_array = function(needle, haystack) {
        for (var i = 0; haystack[i]; i++) {
            if (haystack[i] == needle) {
                return true;
            }
        }
        return false;
    };

    /* Аналог функции nl2br в PHP */
    this.nl2br = function(str) {
        if (typeof(str) == "string") {
            return str.replace(/(\r\n)|(\n\r)|\r|\n/g, '<br />');
        }
        return str;
    };

    /* Аналог функции htmlspecialchars в PHP */
    this.htmlspecialchars = function(str) {
        str = str.replace(/&/g, '&amp;');
        str = str.replace('/\"/g', '&quot;');
        str = str.replace("/\'/g", '&#039;');
        str = str.replace(/</g, '&lt;');
        str = str.replace(/>/g, '&gt;');
        return str
    };

    /*
    Аналог функции strtr в PHP
    pairs = [['a', 'b'], ['c', 'd']];
    str1 = strtr("abcdabcdabcdabcd", pairs);
    str2 = strtr("abcdabcdabcdabcd", "dcba", "hgfe");
    */
    this.strtr = function(str, pairs, to) {
        if ((typeof(pairs)=="object") && (pairs.length)) {
            for (var i in pairs) {
                str = str.replace(new RegExp(pairs[i][0], "g"), pairs[i][1]);
            }
            return str;
        } else {
            var pairs2 = new Array();
            for (i = 0; i < pairs.length; i++) {
                pairs2[i] = [pairs.substr(i,1), to.substr(i,1)];
            }
            return strtr(str, pairs2);
        }
    };

    this.parse();
}

/*
Закончено описание класса bbcode.
Ниже следуют описания функций для работы с textarea
*/

// Remember the current position.
function storeCaret(text) {
	// Only bother if it will be useful.
	if (typeof(text.createTextRange) != "undefined")
		text.caretPos = document.selection.createRange().duplicate();
}

// Replaces the currently selected text with the passed text.
function replaceText(text, textarea) {
	// Attempt to create a text range (IE).
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange) {
		var caretPos = textarea.caretPos;
		if (caretPos.text.charAt(caretPos.text.length - 1) == ' ') {
		    caretPos.text = text + ' ';
		} else {
		    caretPos.text = text;
		}
		caretPos.select();
	}
	// Mozilla text range replace.
	else if (typeof(textarea.selectionStart) != "undefined") {
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var scrollPos = textarea.scrollTop;

		textarea.value = begin + text + end;

		if (textarea.setSelectionRange)
		{
			textarea.focus();
			textarea.setSelectionRange(begin.length + text.length, begin.length + text.length);
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put it on the end.
	else {
		textarea.value += text;
		textarea.focus(textarea.value.length - 1);
	}
}

// Surrounds the selected text with text1 and text2.
function surroundText(text1, text2, textarea) {
	textarea = xbb_textarea;
	// Can a text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange) {
		var caretPos = textarea.caretPos, temp_length = caretPos.text.length;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text1 + caretPos.text + text2 + ' ' : text1 + caretPos.text + text2;

		if (temp_length == 0) {
			caretPos.moveStart("character", -text2.length);
			caretPos.moveEnd("character", -text2.length);
			caretPos.select();
		}
		else
			textarea.focus(caretPos);
	}
	// Mozilla text range wrap.
	else if (typeof(textarea.selectionStart) != "undefined") {
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;

		textarea.value = begin + text1 + selection + text2 + end;

		if (textarea.setSelectionRange) {
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length, newCursorPos + text1.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put them on the end, then.
	else {
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}
}

function doinsert(text1, text2) {
    textarea = xbb_textarea;
	// Can a text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange)
	{
		var caretPos = textarea.caretPos, temp_length = caretPos.text.length;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?  caretPos.text + text1 + text2 + ' ' :  caretPos.text + text1 + text2;

		if (temp_length == 0)
		{
			caretPos.moveStart("character", 0);
			caretPos.moveEnd("character", 0);
			caretPos.select();
		}
		else
			textarea.focus(caretPos);
	}
	// Mozilla text range wrap.
	else if (typeof(textarea.selectionStart) != "undefined")
	{
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;

		textarea.value = begin + text1 + selection + text2 + end;

		if (textarea.setSelectionRange)
		{
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length + text2.length , newCursorPos + text1.length + text2.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put them on the end, then.
	else
	{
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}

}

function tag_url()
{
    var FoundErrors = '';
    var enterURL   = prompt(text_enter_url, "http://");
    var enterTITLE = prompt(text_enter_url_name, "My WebPage");

    if (!enterURL || enterURL=='http://') {FoundErrors = 1;}
    else if (!enterTITLE) {FoundErrors = 1;}

    if (FoundErrors) {return;}

    doinsert ('[url=' + enterURL + ']'+enterTITLE, '[/url]');
}

function tag_email()
{
    var emailAddress = prompt(text_enter_email, "");

    if (!emailAddress) {return;}

    doinsert("[email]"+emailAddress,"[/email]");
}

function tag_image()
{
    var FoundErrors = '';
    var enterURL   = prompt(text_enter_image, "http://");

    if (!enterURL || enterURL=='http://' || enterURL.length<10) {return;}

    doinsert("[img]"+enterURL,"[/img]");
}

function tag_list()
{
    var listvalue = "init";
    var thelist = "";

    while ( (listvalue != "") && (listvalue != null) ) {
        listvalue = prompt(list_prompt, "");
        if ( (listvalue != "") && (listvalue != null) ) {
            thelist = thelist+"[*]"+listvalue+"\n";
        }
    }

    if ( thelist != "" ) {
        doinsert( "[list]\n" + thelist, "[/list]\n");
    }
}
