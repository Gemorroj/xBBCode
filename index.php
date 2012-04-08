<?php

/******************************************************************************
 *                                                                            *
 *   index.php, v 0.07 2007/07/26 - This is part of xBB library               *
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

error_reporting(E_ALL | E_STRICT);
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>xBBEditor demo</title>
<meta name="author" content="Dmitriy Skorobogatov" />
<link href="./style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src='./xbb.js.php'></script>
<script type="text/javascript">
XBB.textarea_id = 'test_js'; // идентификатор textarea
XBB.area_width = '700px';
XBB.area_height = '400px';
XBB.state = 'plain'; // 'plain' or 'highlight'
XBB.lang = 'ru_utf8'; // локализация
onload = function() {
    XBB.init(); // инициалиизация редактора
}
</script>
</head>
<body>

<table border="0" width="100%"><tr><td id="top">
<a href="http://xbb.uz"><img src="./images/xbb.jpg" alt="xBB" id="xbb_logo" /></a>
<div id="top_links"><a href="http://xbb.uz">Документация</a></div>
<h1 id="top_h1">xBB - PHP-библиотека для работы с BBCode. Версия 0.29</h1>
</td></tr><tr valign="top"><td id="content">

<div align="center">
<form action="preview.php" name="test" target="_blank" method="post">
<textarea style="width:700px;height:400px" name="xbb_textarea" id="test_js">[h1 align=center]xBB версии 0.29[/h1]

Основные отличия от версии 0.28:

[ol]
[*]Исправлены баги. Теги не добавлялись "на лету", - исправлено. Ссылки вида [nobb]'www.чего-то'[/nobb] преобразовывались к виду [nobb]'./www.чего-то'[/nobb], - исправлено. Теперь они, как положено, преобразуются к виду [nobb]'http://www.чего-то'[/nobb].

[*]С учетом особенностей IE (код '&lt;br /&gt;&lt;br /&gt;' равносилен коду '&lt;br /&gt;') несколько изменено форматирование текста. Теперь в IE текст выглядит более ожидаемо. В других браузерах все выглядит как раньше.

[*]Добавлены новые теги: [bbcode]@l;bdo@r;, @l;big@r;, @l;blockquote@r;, @l;br@r;, @l;cite@r;, @l;del@r;, @l;em@r;, @l;h4@r;, @l;h5@r;, @l;h6@r;, @l;ins@r;, @l;ol@r;, @l;p@r;, @l;pre@r;, @l;small@r;, @l;strong@r;, @l;ul@r;, @l;var@r;[/bbcode].

[*]Изменена конвертация в HTML тега [bbcode]@l;quote@r;[/bbcode]. Контейнер [tt]div[/tt] заменен на более семантически правильный [tt]blockquote[/tt].

[*]Изменен дизайн тестовых примеров.
[/ol]

Внесены изменения в [b]xBBEditor[/b]:

[ol]
[*]Для ускорения загрузки и работы, поддержания работоспособности редактора при разрыве соединения пришлось отказаться от технологии Ajax для подсветки кода. Для этого парсер был переписан на клиентском JavaScript в объеме, достаточном для подсветки кода.

[*]Исправил глюк. Если форма с редактором находилась внизу страницы, то при загрузке редактора страница прокручивалась вниз. Теперь этого не происходит.

[*]Переработал тулбар. Теперь внешний вид кнопок при активации/нажатии меняется средствами CSS, а не путем перегрузки картинки. Таким образом уменьшен объем загружаемых картинок и тулбар не "едет" в случае разрыва соединения с нетом. Уменьшен вес всех кнопок.

[*]Убрал левую панель. Для вставки смайликов создал специальную кнопку. Для информации о программе, - тоже. Тем самым расширена рабочая область редактора.

[*]Исправил глюк. Если редактор находился в режиме подсветки кода, то в FF при сабмите формы проподали переводы строк. Теперь этого не происходит.

[*]Добавил кнопку предварительного просмотра.

[*]Создал еще один конфигурационный файл, который определяет список шрифтов, палитру цветов и основные смайлики, предлагаемые на выбор пользователя.
[/ol]

Тем не менне должен предупредить, что [b]xBBEditor[/b] пока еще остается сырым экспериментальным приложением. Использовать его в рабочих проектах рекомендуется с большой осторожностью. Парсер xBB никак не зависит от xBBEditor-а и может быть использован в паре с любым другим редактором или без какого либо редактора.

Документацию исправлю в ближайшее время
[right][i][b]Дмитрий Скоробогатов[/b], 25.07.2007[/i][/right]</textarea>
<br />&nbsp;<br />
<input type="submit" value="Send" />
</form>
</div>

</td></tr></table>
<div align="center">
<p align="center">&copy; 2006-2007, Dmitriy Skorobogatov</p>
<a href="http://sourceforge.net/projects/xbb-code/" target="_blank"><img
src="http://sourceforge.net/sflogo.php?group_id=192988" width="88"
height="31" border="0" alt="SourceForge.net Logo" /></a>
</div>
</body>
</html>
